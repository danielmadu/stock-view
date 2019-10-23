<?php


namespace App\Repositories;


use App\Clients\IEXStockClient;
use Illuminate\Support\Facades\Cache;

class StockRepository
{

    private $client;

    public function __construct()
    {
        $this->client = new IEXStockClient();
    }

    public function getStock($symbol)
    {
        return Cache::remember($symbol, now()->addMinute(), function () use($symbol) {
            return json_decode($this->client->getStock($symbol));
        });
    }

    public function getCompany($symbol)
    {
        return Cache::rememberForever('company:'.$symbol, function () use($symbol) {
            $response = json_decode($this->client->getCompany($symbol));
            $responseLogo = json_decode($this->client->getLogo($symbol));
            $response->logoUrl = $responseLogo->url;

            return $response;
        });
    }

    public function getHistory($symbol, $range)
    {
        if($range === 'dynamic') {
            $time = now()->addMinute();
        } else {
            $time = now()->addHours(3);
        }
        return Cache::remember('history:'.$symbol.':'.$range, $time, function () use($symbol, $range) {
            return json_decode($this->client->getHistory($symbol, $range));
        });
    }

}
