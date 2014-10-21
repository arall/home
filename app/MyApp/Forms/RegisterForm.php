<?php

namespace MyApp\Forms;

use Laracasts\Validation\FormValidator;

class RegisterForm extends FormValidator
{
    /**
     * Validation rules for register form
     *
     * @var array
     */
    protected $rules = [
        'username'  => 'required|min:5|alpha_dash|unique:users,username',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:6|confirmed',
    ];
}
