import React, {useState} from 'react';

const Search = ({onClick}) => {
    const [symbol, setSymbol] = useState('');
    return (
        <div className="row">
            <div className="col-md-3">
                <div className="form-group">
                    <input type="text" id="symbol" value={symbol} onChange={event => setSymbol(event.target.value)} className="form-control" placeholder="Stock symbol"/>
                </div>
            </div>
            <div className="col-md-2">
                <button className="btn btn-primary mb-2" onClick={() => onClick(symbol)}>Search</button>
            </div>
        </div>
    );
};

export default Search;
