<?php

use MyApp\Forms\LoginForm;

class AuthController extends BaseController
{
    /**
     * Login Form
     * @var LoginForm
     */
    protected $loginForm;

    /**
     * Contructor
     *
     * @param LoginForm $loginForm
     */
    public function __construct(LoginForm $loginForm)
    {
        // Login validation form
        $this->loginForm = $loginForm;

        // Guest filter
        $this->beforeFilter('guest', array('except' => array('logout')));

        // Auth filter
        $this->beforeFilter('auth', array('only' => array('logout')));
    }

    /**
     * Login form view
     *
     * @return Response
     */
    public function index()
    {
        // Show the login form view
        return View::make('auth.login');
    }

    /**
     * Login action
     *
     * @return Response
     */
    public function login()
    {
        // Form validation
        $this->loginForm->validate(Input::all());

        // Try to log the user in
        if (!Auth::attempt(Input::only(['username', 'password']), Input::get('remember'))) {
            // Message
            Flash::error(Lang::get('messages.login.incorrect'));
            // Redirect to the login page
            return Redirect::back();
        }

        // Redirect to homepage (intended)
        return Redirect::intended('/');
    }

    /**
     * Logout action
     *
     * @return Response
     */
    public function logout()
    {
        // Log out
        Auth::logout();

        // Redirect to homepage
        return Redirect::to('/');
    }
}
