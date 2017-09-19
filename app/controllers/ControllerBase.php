<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class ControllerBase extends Controller
{
    /**
     * Api Client
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Current logged user
     *
     * @var array
     */
    protected $userData;

    public function initialize()
    {
        Tag::setTitle(' - News App');        
        $this->client = new \GuzzleHttp\Client(['base_uri' => 'http://api.newsapp/api/']);
        $this->userData = $this->session->get('user');
    }
}