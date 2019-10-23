<?php


namespace App\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;


class ClientBase implements ClientInterface
{

    protected  $client;

    protected $baseUri;

    public function __construct($baseUri)
    {
        $this->baseUri = $baseUri;
//        $this->client = new Client([
//            'base_uri' => $baseUri
//        ]);
        $this->client = app()->make('services.http', ['config' => ['base_uri' => $baseUri]]);
    }

    public function get($uri, $query = [])
    {
        try {
            return $this->client->request(ClientBase::GET, $uri, ['query' => $query])->getBody();
        } catch (ClientException $e) {
            throw $e;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    public function getBaseUri()
    {
        return $this->baseUri;
    }
}
