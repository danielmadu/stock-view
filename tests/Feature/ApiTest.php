<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{

    public function testGetSymbol()
    {
        $response = $this->get('/api/stock/aapl');

        $response->assertStatus(200);

        $response->assertJsonCount(4);
    }

    public function testGetCompanyInfosFromSymbol()
    {
        $response = $this->get('/api/stock/aapl/company');

        $response->assertStatus(200);

        $response->assertExactJson([
            "companyName" => "Apple, Inc.",
            "exchange" => "NASDAQ",
            "logoUrl" => "https://storage.googleapis.com/iexcloud-hl37opg/api/logos/AAPL.png",
        ]);
    }

    public function testGetRangeFromSymbol()
    {
        $response = $this->get('/api/stock/aapl/history/5d');

        $response->assertStatus(200);

        $response->assertJsonCount(5);
    }
}
