<?php

use MyApp\Forms\RegisterForm;

class RegisterController extends BaseController
{
    /**
     * Register Form
     * @var RegisterForm
     */
    protected $registerForm;

    /**
     * Contructor
     *
     * @param LoginForm $loginForm
     */
    public function __construct(RegisterForm $registerForm)
    {
        // Register validation form
        $this->registerForm = $registerForm;

        // Guest filter
        $this->beforeFilter('guest', array('only' => array('index', 'register')));
    }

    /**
     * Register form view
     *
     * @return Response
     */
    public function index()
    {
        // Show the register form view
        return View::make('register.index');
    }

    /**
     * Register action
     *
     * @return Response
     */
    public function register()
    {
        // Form validation
        $this->registerForm->validate(Input::all());

        // Save data
        $user = User::create(Input::only(['username', 'email', 'password']));

        // Email confirmation
        Mail::send('emails.verify', array('confirmation_code' => $user->confirmation_code), function ($message) {
            $message->to(Input::get('email'), Input::get('username'))->subject('Verify your email address');
        });

        // Login
        Auth::login($user);

        // Message
        Flash::success(Lang::get('messages.register.done'));

        // Redirect to homepage
        return Redirect::to('/');
    }

    /**
     * Email verification action
     *
     * @return Response
     */
    public function verify($confirmation_code)
    {
        // Search user by confirmation code
        $user = User::where('confirmation_code', $confirmation_code)->first();
        if (!$user) {
            Flash::error(Lang::get('messages.register.verify.code_not_found'));

            return Redirect::to('/');
        }

        // Update model
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        // Authenticate user
        Auth::login($user);

        // Message
        Flash::success(Lang::get('messages.register.verify.done'));

        // Redirect to homepage
        return Redirect::to('/');
    }
}
