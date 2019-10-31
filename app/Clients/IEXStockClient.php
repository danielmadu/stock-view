<?php


namespace App\Clients;

use GuzzleHttp\Exception\GuzzleException;
use App\Clients\ClientBase as Client;

final class IEXStockClient extends Client
{

    private $config;
    protected $uri = '/stable/stock/{symbol}';

    public function __construct()
    {
        $this->config = config('stock.drivers.iex');
        parent::__construct($this->config['api_url']);
    }

    public function getStock($symbol)
    {
        try {
            return $this->get($this->parseUri($symbol) . '/quote', array_merge($this->auth(), $this->filters(), $this->options()))->getContents();
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    public function getCompany($symbol)
    {
        try {
            return $this->get($this->parseUri($symbol) . '/company', $this->auth())->getContents();
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    public function getLogo($symbol)
    {
        try {
            return $this->get($this->parseUri($symbol) . '/logo', $this->auth())->getContents();
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    public function getHistory($symbol, $range)
    {
        try {
            return $this->get($this->parseUri($symbol) . '/chart/'.$range, $this->auth())->getContents();
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    public function getLastNews($symbol, $qtd = 1)
    {
        try {
            return $this->get($this->parseUri($symbol) . '/news/last/'.$qtd, $this->auth())->getContents();
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    protected function auth()
    {
        return [
            'token' => $this->config['publishable']
        ];
    }

    protected function filters()
    {
        return [
            'filter' => implode(',', [
                'latestPrice',
                'latestTime',
                'change',
                'changePercent',
                'companyName',
            ])
        ];
    }
    protected function options()
    {
        return [
            'displayPercent' => true
        ];
    }

    protected function parseUri($symbol)
    {
        return str_replace('{symbol}', $symbol, $this->uri);
    }
}
