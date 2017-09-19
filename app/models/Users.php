<?php

namespace Newsapp\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Uniqueness;

class Users extends \Baka\Database\Model
{
    public $name;
    public $lastName;
    public $email;
    public $password;

    public function initialize()
    {
        $this->hasMany('id', 'Newsapp\Models\News', 'user_id', ['alias' => 'news']);
        $this->hasMany('id', 'Newsapp\Models\Comments', 'user_id', ['alias' => 'comments']);
    }
}
