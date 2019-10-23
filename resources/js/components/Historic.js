import React from 'react';
import {Area, AreaChart, CartesianGrid, ResponsiveContainer, Tooltip, XAxis, YAxis} from "recharts";

const Historic = ({historicalPrices, historicalSelected, symbol, getHistoric}) => {
    return (
        <div className="row">
            <div className="col-md-6">
                <button className={`btn btn-${historicalSelected === 'dynamic' ? 'primary' : 'secondary'}`} onClick={e => getHistoric(symbol, 'dynamic')}>1D</button>
                <button className={`btn btn-${historicalSelected === '5d' ? 'primary' : 'secondary'}`} onClick={e => getHistoric(symbol, '5d')}>5D</button>
                <button className={`btn btn-${historicalSelected === '1m' ? 'primary' : 'secondary'}`} onClick={e => getHistoric(symbol, '1m')}>1M</button>
                <button className={`btn btn-${historicalSelected === '3m' ? 'primary' : 'secondary'}`} onClick={e => getHistoric(symbol, '3m')}>3M</button>
                <button className={`btn btn-${historicalSelected === '6m' ? 'primary' : 'secondary'}`} onClick={e => getHistoric(symbol, '6m')}>6M</button>
                <button className={`btn btn-${historicalSelected === '1y' ? 'primary' : 'secondary'}`} onClick={e => getHistoric(symbol, '1y')}>1Y</button>
            </div>
            <div className="col-md-12">
                <div style={{width: '100%', height: 300}}>
                    <ResponsiveContainer>
                        <AreaChart data={historicalPrices}>
                            <Area type="monotone" dataKey="high" name="Valor" fill="#8884d8" dot={false} connectNulls={true} />
                            <CartesianGrid stroke="#ccc" strokeDasharray="3 3" />
                            <XAxis dataKey="label" />
                            <YAxis domain={['dataMin - 1', 'dataMax + 1']} />
                            <Tooltip />
                        </AreaChart>
                    </ResponsiveContainer>
                </div>
            </div>
        </div>
    );
};

export default Historic;
