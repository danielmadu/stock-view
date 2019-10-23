<?php

namespace Tests\Unit;

use App\Clients\ClientBase;
use Mockery;
use Tests\TestCase;
use GuzzleHttp\Psr7\Response;


class ClientBaseTest extends TestCase
{
    /**
     * @var ClientBase
     */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $mock = Mockery::mock();
        $mock->shouldReceive('request')->andReturn(new Response(200, ['X-Foo' => 'Bar']));

        $this->app->bind('services.http', function () use($mock) {
            return $mock;
        });
        $this->client = new ClientBase('http://localhost');

    }

    public function testBaseUri()
    {
        $this->assertEquals('http://localhost', $this->client->getBaseUri());
    }

    public function testGet()
    {
        $this->assertEquals('', $this->client->get('/test'));
    }
}
