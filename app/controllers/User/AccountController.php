<?php

class AccountController extends BaseController
{
    /**
     * Account details form view
     *
     * @return Response
     */
    public function getAccount()
    {
        // Show the creation form view
        return View::make('account.index')->with('user', Auth::user());
    }

    /**
     * Account save action
     *
     * @return Response
     */
    public function postAccount()
    {
        // Model
        $user = Auth::user();

        // Validation
        $rules = User::$rules;
        $rules['username'] = str_replace('{ignore_id}', $user->id, $rules['username']);
        $rules['email'] = str_replace('{ignore_id}', $user->id, $rules['email']);
        if (!Input::get('password')) {
            unset($rules['password']);
        }
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success.
        if ($validator->passes()) {

            // Save data
            $user->status = 1;
            $user->update(Input::all());

            // Message
            Flash::success(Lang::get('messages.data.saved'));

            // Redirect to account page
            return Redirect::back();
        }

        // Something went wrong
        return Redirect::back()->withErrors($validator);
    }
}
