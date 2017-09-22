<?php

use GuzzleHttp\Psr7\Request;
use Newsapp\Models\Users;
use Phalcon\Http\Response;
use Phalcon\Tag;

/**
 * Class used to manage accounts
 */
class AccountController extends ControllerBase
{
    /**
     * Displays the login view
     *
     * @method GET
     * @url /account/login
     */
    public function loginGetAction()
    {
        $this->view->pick("account/login");
        Tag::prependTitle('Login');
        $this->view->email = '';
    }

    /**
     * If the credentials are right, lets the user login
     *
     * @method POST
     * @url /account/login
     */
    public function loginAction()
    {
        Tag::prependTitle('Login');
        
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
        $this->view->email = $email;
    }

    /**
     * Displays the register view
     *
     * @method GET
     * @url /account/register
     */
    public function registerGetAction()
    {
        $this->view->pick("account/register");
        Tag::prependTitle('Register');
        $this->view->name = '';
        $this->view->lastName = '';
        $this->view->email = '';
    }

    /**
     * If the data fulfill the rules registers a new user
     *
     * @method POST
     * @url /account/register
     */
    public function registerAction()
    {
        Tag::prependTitle('Register');
        $name = $this->request->getPost('name');
        $lastName = $this->request->getPost('lastName');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        if ($password !== $this->request->getPost('confirmPassword')) {
            $error = new stdClass();
            $error->field = 'confirm_password';
            $error->message = "The confirm password doesn't match.";
            $this->view->errors = [$error];
        } else {
            $request = new Request('POST', 'account/register');
            try {
                $response = $this->client->send($request, [
                    'form_params' => [
                        'email' => $email,
                        'password' => $password,
                        'name' => $name,
                        'lastName' => $lastName
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
     */
    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('/');
    }
}
