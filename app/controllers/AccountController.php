<?php

use Newsapp\Models\Users;
use Phalcon\Http\Response;
use GuzzleHttp\Psr7\Request;

/**
 * Class used to manage accounts
 */
class AccountController extends ControllerBase
{
    /**
     * If the credentials are right, lets the user login
     *
     * @method POST
     * @url /account/login
     *
     * @return Phalcon\Http\Response
     */
    public function loginAction()
    {
        $email = '';
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $request = new Request('POST', 'account/login');
            try {
                $response = $this->client->send($request, [
                    'form_params' => [
                        'email' => $email,
                        'password' => $password
                    ]
                ]);

                if ($response->getStatusCode() == 200) {
                    $user = json_decode($response->getBody());

                    $this->session->set(
                        'user',
                        [
                            'id' => $user->id,
                            'name' => $user->name,
                            'lastName' => $user->lastName,
                            'email' => $user->email
                        ]
                    );
                }

                $this->response->redirect('/');
            } catch (\Exception $e) {
                $this->view->errors = json_decode($e->getResponse()->getBody())->errors;
            }
        }
        $this->view->email = $email;
    }

    /**
     * If the data fulfill the rules registers a new user
     *
     * @method POST
     * @url /account/register
     *
     * @return Phalcon\Http\Response
     */
    public function registerAction()
    {
        $name = '';
        $lastName = '';
        $email = '';
        if ($this->request->isPost()) {
            $name = $this->request->getPost('name');
            $lastName = $this->request->getPost('lastName');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            if ($password !== $this->request->getPost('confirmPassword')) {
                $this->view->errors = [[
                    'field' => 'confirm_password',
                    'message' => "the passwords don't match."
                ]];
                return;
            }

            $request = new Request('POST', 'account/register');
            try {
                $response = $this->client->send($request, [
                    'form_params' => [
                        'name' => $name,
                        'lastName' => $lastName,
                        'email' => $email,
                        'password' => $password
                    ]
                ]);

                if ($response->getStatusCode() == 200) {
                    $user = json_decode($response->getBody());

                    $this->session->set(
                        'user',
                        [
                            'id' => $user->id,
                            'name' => $user->name,
                            'lastName' => $user->lastName,
                            'email' => $user->email
                        ]
                    );
                }

                $this->response->redirect('/');
            } catch (\Exception $e) {
                $this->view->errors = json_decode($e->getResponse()->getBody())->errors;
            }
        }
        $this->view->name = $name;
        $this->view->lastName = $lastName;
        $this->view->email = $email;
    }

    /**
     * Logouts the current user if there is any
     *
     * @method GET
     * @url /account/logout
     *
     * @return Phalcon\Http\Response
     */
    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('/');
    }
}
