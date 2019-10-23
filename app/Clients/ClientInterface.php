<?php


namespace App\Clients;


interface ClientInterface
{
    const GET = 'GET';
    const POST = 'GET';
    const PUT = 'GET';
    const DELETE = 'GET';
    const HEAD = 'HEAD';

    public function get($uri, $query);
}
