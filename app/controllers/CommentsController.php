<?php

use GuzzleHttp\Psr7\Request;
use Phalcon\Tag;

class CommentsController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        if (is_null($this->userData)) {
            $this->response->redirect('/');
        }
    }

    public function addCommentAction(int $newsId)
    {
        $this->view->disable();

        $content = $this->request->getPost('content');

        $request = new Request('POST', 'comments');

        $response = $this->client->send($request, [
            'form_params' => [
                'content' => $content,
                'news_id' => $newsId,
                'user_id' => $this->userData['id']
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new \Exception('Error uploading comment');
        }

        $this->response->redirect("/news/detail/{$newsId}");
    }

    /**
     * Updates the given information of an existing post
     */
    public function editCommentAction()
    {
        $this->view->disable();
        
        $id = $this->request->getPost('commentId');
        
        if (is_null($id)) {
            throw new \exception('Comment not Found');
        }

        $url = "comments/{$id}";

        $response = $this->client->request('GET', $url);
        if ($response->getStatusCode() == 200) {
            $comment = json_decode($response->getBody());
            if ($comment->user_id !== $this->userData['id']) {
                throw new \Exception("You aren't the owner of the comment.");
            }
        }

        $request = new Request('PUT', $url);

        $response = $this->client->send($request, [
            'form_params' => [
                'content' => $this->request->getPost('content')
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new \Exception('Error editing comment');
        }

        $this->response->redirect('/news/detail/' . $comment->news_id);
    }

    public function deleteCommentAction()
    {
        $this->view->disable();
        
        $id = $this->request->getPost('commentId');

        if (is_null($id) || $id == '') {
            throw new \exception('Comment not Found');
        }

        $url = "comments/{$id}";

        $response = $this->client->request('GET', $url);
        if ($response->getStatusCode() == 200) {
            $comment = json_decode($response->getBody());
            if ($comment->user_id !== $this->userData['id']) {
                throw new \Exception("You aren't the owner of the comment.");
            }
        }

        $request = new Request('DELETE', $url);

        $response = $this->client->send($request);
    
        $this->response->redirect('/news/detail/' . $comment->news_id);
    }
}
