<?php

class RemindersController extends Controller
{
    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function getRemind()
    {
        return View::make('password.remind');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postRemind()
    {
        switch ($response = Password::remind(Input::only('email'))) {
            case Password::INVALID_USER:
                Flash::error(Lang::get($response));
                break;

            case Password::REMINDER_SENT:
                Flash::success(Lang::get($response));
                break;

            return Redirect::back();
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string   $token
     * @return Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) App::abort(404);
        return View::make('password.reset')->with('token', $token);
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {
        $credentials = Input::only(
            'password', 'password_confirmation', 'token'
        );
        $credentials['email'] = DB::table(Config::get('auth.reminder.table'))->where('token', Input::get('token'))->pluck('email');
        $response = Password::reset($credentials, function ($user, $password) {
            // Save new password
            $user->password = $password;
            $user->save();
            // Authenticate user
            Auth::login($user);
        });

        switch ($response) {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
            case Password::INVALID_USER:
                Flash::error(Lang::get($response));

                return Redirect::back();

            case Password::PASSWORD_RESET:
                Flash::success(Lang::get('messages.reminder.done'));

                return Redirect::to('/');
        }
    }

}
