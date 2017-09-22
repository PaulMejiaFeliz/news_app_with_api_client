<?php

use Phalcon\Tag;

class IndexController extends ControllerBase
{
    /**
     * Displays the error page
     *
     * @param string $message opcional error message
     * @return void
     */
    public function errorAction(string $message = null)
    {
        Tag::prependTitle('Error');

        if (!is_null($message)) {
            $this->view->message = $message;
        }
    }
}
