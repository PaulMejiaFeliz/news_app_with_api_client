<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected $client;

    public function initialize()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => 'http://v4.api.newsapp/api/']);
    }
}
