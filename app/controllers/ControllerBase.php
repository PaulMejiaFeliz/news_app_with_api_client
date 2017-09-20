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

    /**
     * Sets the api client, gets the current user data and sets the title of the web
     *
     * @return void
     */
    public function initialize()
    {
        Tag::setTitle(' - News App');
        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->config->application->api_url]);
        $this->userData = $this->session->get('user');
    }
}