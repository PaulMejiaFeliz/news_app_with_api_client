<?php
namespace Newsapp\Controllers;

use Newsapp\Models\Users;
use Phalcon\Http\Response;

/**
 * Class used to manage accounts
 */
class AccountController extends BaseController
{

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
        $this->redirect('/');
    }

    /**
     * Saves a user in the session
     *
     * @param Users $user
     * @return void
     */
    private function loginUser(Users $user) : void
    {
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
}
