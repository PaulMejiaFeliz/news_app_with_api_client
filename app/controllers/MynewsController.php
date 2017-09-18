<?php

use GuzzleHttp\Psr7\Request;

class MynewsController extends ControllerBase
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

    /**
     * Current logged user
     *
     * @var array
     */
    private $userData;
        
    public function initialize()
    {
        parent::initialize();
        $this->userData = $this->session->get('user');
    }

    public function indexAction()
    {
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
        $queryString .= 'user_id=' . $this->userData['id'];
        $queryString .= '&page=' . $this->request->getQuery('page', 'int', 1);

        $response = $this->client->request('GET', $url . $queryString);
        if ($response->getStatusCode() == 200) {
            $this->view->page = json_decode($response->getBody());
        }

        $this->view->searchFields = $this->searchFields;
        $this->view->searchField = $searchField;
        $this->view->searchValue = $searchValue;
    }

    public function addPostAction()
    {
        $title = '';
        $content = '';
        $email = '';
        if ($this->request->isPost()) {
            $title = $this->request->getPost('title');
            $content = $this->request->getPost('content');

            $request = new Request('POST', 'news');
            try {
                $response = $this->client->send($request, [
                    'form_params' => [
                        'title' => $title,
                        'content' => $content,
                        'user_id' => $this->userData['id']
                    ]
                ]);

                if ($response->getStatusCode() == 200) {
                    $news = json_decode($response->getBody());
                    $this->response->redirect("/news/postDetails/{$news->id}");
                }
            } catch (\Exception $e) {
                $this->view->errors = json_decode($e->getResponse()->getBody())->errors;
            }
        }
        $this->view->title = $title;
        $this->view->content = $content;
    }
}
