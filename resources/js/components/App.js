import React from 'react';
import ReactDOM from 'react-dom';

import Search from './Search';
import StockInfo from "./StockInfo";
import Historic from "./Historic";

class App extends React.Component {

    state = {
        latestPrice: 0,
        change: 0,
        changePercent: 0,
        symbol: null,
        companyInfo: {},
        lastNews: {},
        error: false,
        show: false,
        history: [],
        historicalPrices: [],
        historicalSelected: 'dynamic'
    };

    componentDidMount() {
        this.timerID = setInterval(() => {
            if(!this.state.error && this.state.show) {
                this.getLastPrice(this.state.symbol)
            }
        }, 60*1000);

        this.historicInterval();
    }

    historicInterval = () => {
        this.historicTimerID = setInterval(() => {
            if((this.state.historicalSelected === 'dynamic' && this.state.symbol !== null) && (!this.state.error && this.state.show)) {
                this.getHistoric(this.state.symbol, 'dynamic');
            }
        }, 60*1000);
    };

    componentDidUpdate(prevProps, prevState, snapshot) {
        if(this.state.historicalSelected !== 'dynamic' && prevState.historicalSelected === 'dynamic') {
            clearInterval(this.historicTimerID);
        }

        if(prevState.historicalSelected !== 'dynamic' && this.state.historicalSelected === 'dynamic') {
            this.historicInterval();
        }
    }

    componentWillUnmount() {
        clearInterval(this.timerID);
    }

    getHistoric = (symbol, range) => {
        this.setState({historicalSelected: range});
        axios.get(`http://localhost:8000/api/stock/${symbol}/history/${range}`)
            .then(response => {
                this.setState({historicalPrices: response.data})
            })
            .catch(error => {
                this.setState({error: true});
                console.log(error);
            });
    };

    getLastPrice = (symbol) => {
        if(this.state.symbol !== symbol) {
            this.setState({symbol, show: false, history: []});
        }
        axios.get(`http://localhost:8000/api/stock/${symbol}`)
            .then(response => {
                this.setState({
                    latestPrice: response.data.latestPrice,
                    change: response.data.change,
                    changePercent: response.data.changePercent,
                    error: false,
                });

                if(response.data.stopLogging) {
                    this.setState({
                        history: [
                            {
                                latestPrice: response.data.latestPrice,
                                high: response.data.high,
                                low: response.data.low,
                                time: response.data.latestTime,
                            }
                        ]
                    });
                    return;
                }
            })
            .catch(error => {
                this.setState({error: true});
                console.log(error);
            })
            .finally(() => this.setState({show: true}));
    };

    getCompany = (symbol) => {
      axios.get(`http://localhost:8000/api/stock/${symbol}/company`)
          .then(response => {
                console.log(response.data);
                this.setState({companyInfo: response.data})
          })
          .catch(error => {
              // this.setState({error: true});
              console.log(error);
          });
    };

    getLastNews = (symbol) => {
        axios.get(`http://localhost:8000/api/stock/${symbol}/lastNews`)
            .then(response => {
                console.log(response.data);
                this.setState({lastNews: response.data})
            })
            .catch(error => {
                // this.setState({error: true});
                console.log(error);
            });
    };

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Stock</div>

                            <div className="card-body">
                                <Search getLastPrice={this.getLastPrice} getCompany={this.getCompany} onClick={symbol => {
                                    this.getLastPrice(symbol);
                                    this.getCompany(symbol);
                                    this.getHistoric(symbol, 'dynamic');
                                    this.getLastNews(symbol);
                                }}/>
                            </div>

                            {this.state.show ?
                                (
                                    <div className="card-body">
                                        {
                                            this.state.error ? (<span>Não foi possível localizar a ação {this.state.symbol}!</span>) :
                                            (
                                                <>
                                                    <StockInfo
                                                        change={this.state.change}
                                                        changePercent={this.state.changePercent}
                                                        companyInfo={this.state.companyInfo}
                                                        latestPrice={this.state.latestPrice}
                                                    />

                                                    <Historic
                                                        historicalPrices={this.state.historicalPrices}
                                                        historicalSelected={this.state.historicalSelected}
                                                        symbol={this.state.symbol}
                                                        getHistoric={this.getHistoric}
                                                    />

                                                    <div className="row">
                                                        <div className="col-md-12">
                                                            <div className="card">
                                                                <div className="card-body">
                                                                    <h5 className="card-title">
                                                                        {this.state.lastNews.headline}
                                                                    </h5>
                                                                    <h6 className="card-subtitle mb-2 text-muted">{this.state.lastNews.dateFormatted}</h6>
                                                                    <div className="card-body">
                                                                        {this.state.lastNews.summary}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </>
                                            )
                                        }
                                    </div>
                                ): null}
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
