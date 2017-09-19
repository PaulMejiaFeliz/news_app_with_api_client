<?php

use Phalcon\Tag;

class NewsController extends ControllerBase
{
    /**
     * Array of the columns which the news can be filtered
     *
     * @var array
     */
    private $searchFields = [
        'title' => 'Title',
        'views' => 'Views Count',
        'createdAt' => 'Created At',
        'updatedAt' => 'Updated At'
    ];

     /**
     * @var array
     */
    private $orderByFields = [
        'title',
        'user',
        'views',
        'created_at'
    ];

    public function indexAction()
    {
        Tag::prependTitle('Home');        

        $url = 'news/';
        
        $queryString = '?';
        if ($this->request->hasQuery('sort')) {
            $queryString .= 'sort=' . $this->request->getQuery('sort', 'string');
        }

        $searchField = '';
        $searchValue = '';

        if ($this->request->hasQuery('search') && $this->request->hasQuery('value')) {
            $field = $this->request->getQuery('search', 'string');
            if (array_key_exists($field, $this->searchFields)) {
                $value = $this->request->getQuery('value', 'string');

                $queryString .= $queryString == '?' ? '' : '&';
                $queryString .= "{$field}={$value}";

                $searchField = $field;
                $searchValue = $value;
            }
            
        }

        // foreach (array_keys($this->searchFields) as $field) {
        //     if ($this->request->hasQuery($field)) {
        //         $value =  $this->request->getQuery($field, 'string');
                
        //         $queryString .= $queryString == '?' ? '' : '&';
        //         $queryString .= "{$field}={$value}";

        //         $searchField = $field;
        //         $searchValue = $value;
        //     }
        // }

        $queryString .= $queryString == '?' ? '' : '&';
        $queryString .= 'page=' . $this->request->getQuery('page', 'int', 1);

        $response = $this->client->request('GET', $url . $queryString);
        if ($response->getStatusCode() == 200) {
            $this->view->page = json_decode($response->getBody());
        }

        $this->view->searchFields = $this->searchFields;
        $this->view->searchField = $searchField;
        $this->view->searchValue = $searchValue;
    }

    public function postDetailsAction(int $id)
    {
        $url = "news/{$id}";
        $url .= '?page=' . $this->request->getQuery('page', 'int', 1);
        
        $response = $this->client->request('GET', $url);
        if ($response->getStatusCode() == 200) {
            $post = json_decode($response->getBody());
            $this->view->post = $post;
            Tag::prependTitle($post->title);
            $url = "news/{$id}/comments";
            $url .= '?page=' . $this->request->getQuery('page', 'int', 1);

            $response = $this->client->request('GET', $url);
            if ($response->getStatusCode() == 200) {
                $this->view->page = json_decode($response->getBody());
            }
        }
    }
}
