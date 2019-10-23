import React from 'react';

const StockInfo = ({companyInfo, latestPrice, change, changePercent}) => {
    return (
        <div className="row">
            <div className="col-md-12">
                <h4>{companyInfo.companyName}</h4>
                <small>{companyInfo.exchange}</small>
                <h2>
                    {parseFloat(latestPrice)}
                    <span className={change >= 0 ? "text-success" : "text-danger"} style={{marginLeft: 10}}>
                        {change ?? 0} ({(changePercent * 100) ?? 0}%)
                    </span>
                </h2>
            </div>
        </div>
    );
};

export default StockInfo;
