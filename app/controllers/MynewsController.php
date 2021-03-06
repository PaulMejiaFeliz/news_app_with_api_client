<?php

use GuzzleHttp\Psr7\Request;
use Phalcon\Tag;

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
     * Accepted image extensions
     *
     * @var array
     */
    private $photosExtensions = array(
        'image/jpeg',
        'image/png',
        'image/bmp'
    );
        
    public function initialize()
    {
        parent::initialize();
        if (is_null($this->userData)) {
            $this->response->redirect('/');
        }
    }

    /**
     * Displays a view with the posts of the current user
     *
     * @method GET
     * @url /myNews
     */
    public function indexAction()
    {
        Tag::prependTitle('My Posts');
        
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

    /**
     * Displays the add post view
     *
     * @method GET
     * @url /news/add
     */
    public function addPostGetAction()
    {
        $this->view->pick("myNews/addPost");
        Tag::prependTitle('Add Post');
        $this->view->title = '';
        $this->view->content = '';
    }

    /**
     * Creates a new post
     *
     * @method POST
     * @url /news/add
     */
    public function addPostAction()
    {
        Tag::prependTitle('Add Post');

        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');

        $request = new Request('POST', 'news');
        
        $data = ['multipart' => [
            [
                'name' => 'title',
                'contents' => $title
            ], [
                'name' => 'content',
                'contents' => $content
            ], [
                'name' => 'user_id',
                'contents' => $this->userData['id']
            ]
        ]];

        $imageNames = [];

        if ($this->request->hasFiles()) {
            foreach ($this->request->getUploadedFiles() as $file) {
                $name = rand();
                $fileName = sys_get_temp_dir() .'/'. $name;
                if (!$file->moveTo($fileName)) {
                    throw new \Exception("The photo couldn't be uploaded");
                }
                $imageNames[] = $fileName;

                $data['multipart'][] =  [
                    'Content-type' => 'multipart/form-data',
                    'name' => $name,
                    'contents' => fopen($fileName, 'r')
                ];
            }
        }
        
        try {
            $response = $this->client->send($request, $data);
            
            if ($response->getStatusCode() == 200) {
                $news = json_decode($response->getBody());
                $this->response->redirect("/news/detail/{$news->id}");
            }
        } catch (\Exception $e) {
            $this->view->errors = json_decode($e->getResponse()->getBody())->errors;
        } finally {
            foreach ($imageNames as $imageName) {
                unlink($imageName);
            }
        }
        $this->view->title = $title;
        $this->view->content = $content;
    }

    /**
     * Displays the edit post view
     *
     * @method GET
     * @url /news/edit/id
     */
    public function editPostGetAction(int $id)
    {
        $this->view->pick("myNews/editPost");
        Tag::prependTitle('Edit Post');

        $url = "news/{$id}";

        $news;

        $response = $this->client->request('GET', $url);
        if ($response->getStatusCode() == 200) {
            $news = json_decode($response->getBody());
            if ($news->user_id !== $this->userData['id']) {
                throw new \Exception("You aren't the owner of the post.");
            }
            $title = $news->title;
            $content = $news->content;
        }
        
        $this->view->id = $id;
        $this->view->title = $news->title;
        $this->view->content = $news->content;
    }

    /**
     * Edits a post
     *
     * @method POST
     * @url /news/edit/id
     */
    public function editPostAction(int $id)
    {
        Tag::prependTitle('Edit Post');

        $url = "news/{$id}";

        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');

        $request = new Request('PUT', $url);
        try {
            $response = $this->client->send($request, [
                'form_params' => [
                    'title' => $title,
                    'content' => $content
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $news = json_decode($response->getBody());
                $this->response->redirect("/news/detail/{$news->id}");
            }
        } catch (\Exception $e) {
            $this->view->errors = json_decode($e->getResponse()->getBody())->errors;
        }
    
        $this->view->id = $id;
        $this->view->title = $title;
        $this->view->content = $content;
    }

    public function deletePostAction()
    {
        Tag::prependTitle('Delete Post');

        $id = $this->request->getPost('PostId');

        if (is_null($id)) {
            throw new \exception('Post not Found');
        }

        $url = "news/{$id}";
        $news;

        $response = $this->client->request('GET', $url);
        if ($response->getStatusCode() == 200) {
            $news = json_decode($response->getBody());
            if ($news->user_id !== $this->userData['id']) {
                throw new \Exception("You aren't the owner of the post.");
            }
        }

        if ($this->request->isPost()) {
            $request = new Request('DELETE', $url);
            try {
                $response = $this->client->send($request);

                if ($response->getStatusCode() == 200) {
                    $this->view->title = $news->title;
                }
            } catch (\Exception $e) {
                $this->view->errors = json_decode($e->getResponse()->getBody())->errors;
            }
        }
        
        $this->view->id = $id;
        $this->view->title = $news->title;
        $this->view->content = $news->content;
    }
}
