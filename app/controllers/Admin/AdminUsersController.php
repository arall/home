<?php

class AdminUsersController extends BaseController
{
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getUsers()
    {
        // Show the page
        return View::make('admin.users.index');
    }

    /**
     * Show the form for creating/editing a new resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function getUser($id = null)
    {
        $user = new User();
        if ($id) {
            $user = User::find($id);
        }

        // Show the page
        return View::make('admin.users.edit')->with('user', $user);
    }

    /**
     * Create/Update the specified resource in storage.
     *
     * @return Response
     */
    public function postUser()
    {
        $user = new User();
        if ($id = Input::get('id')) {
            $user = User::find($id);
        }

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
            if ($user->id) {
                // Save model
                $user->update(Input::all());
            } else {
                // Create model
                User::create(Input::all());
            }

            // Message
            Flash::success('User saved successfully');

            // Redirect to resource list
            return Redirect::to(action('AdminUsersController@getUsers'));
        }

        // Something went wrong
        return Redirect::back()->withErrors($validator)->withInput(Input::all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function getDelete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            // Message
            Flash::success('User deleted successfully');

            // Redirect to resource list
            return Redirect::to(action('AdminUsersController@getUsers'));
        }

        // Message
        Flash::error('User not found');

        // Something went wrong
        return Redirect::back();
    }

    /**
     * Show a list of all the users formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        return Datatable::collection(User::all(array('id','username', 'email')))
        ->showColumns('id', 'username', 'email')
        ->searchColumns('username', 'email')
        ->orderColumns('id', 'username', 'email')
        ->addColumn('actions', function ($model) {
            return
                HTML::decode(
                    HTML::link(action('AdminUsersController@getUser', array($model->id)), '<span class="glyphicon glyphicon-pencil"></span>', array('class' => 'btn btn-primary btn-xs')).
                    HTML::link(action('AdminUsersController@getDelete', array($model->id)), '<span class="glyphicon glyphicon-remove"></span>', array('class' => 'btn btn-danger btn-xs'))
                );
        })
        ->make();
    }
}
