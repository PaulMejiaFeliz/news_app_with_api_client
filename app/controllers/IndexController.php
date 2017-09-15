<?php

class IndexController extends ControllerBase
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
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://v4.api.newsapp/api/']);
        $url = 'news/';

        if (in_array($searchField, array_keys($this->searchFields)) && $searchValue) {
            $url .= "search/{$searchField}/{$searchValue}/";
        }

        if ($order) {
            $url .= "order/{$order}";
        }

        $url .= '?page=' . $this->request->getQuery('page', 'int', 1);

        $response = $client->request('GET', $url);
        if ($response->getStatusCode() == 200) {
            $this->view->page = json_decode($response->getBody());
        }

        $this->view->searchFields = $this->searchFields;
        $this->view->searchField = $searchField;
        $this->view->searchValue = $searchValue;
    }
}
