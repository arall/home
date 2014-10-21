<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Home
Route::get('/', function () {
    return View::make('home');
});

/** ------------------------------------------
 *  Global
 *  ------------------------------------------
 */
Route::when('*', 'csrf', array('post'));

/** ------------------------------------------
 *  Storage
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'storages', 'before' => 'auth'), function () {
    Route::get('/', [
        'as' => 'storages.index',
        'uses' => 'StoragesController@index',
    ]);
    //New
    Route::get('new', [
        'as' => 'storages.new',
        'uses' => 'StoragesController@edit',
    ]);
    //View/edit
    Route::get('view/{id}', [
        'as' => 'storages.view',
        'uses' => 'StoragesController@edit',
    ])->where('id', '[0-9]+');
    //Save
    Route::post('save', [
        'as' => 'storages.save',
        'uses' => 'StoragesController@save',
    ]);
    //Delete
    Route::get('delete/{id}', [
        'as' => 'storages.delete',
        'uses' => 'StoragesController@delete',
    ])->where('id', '[0-9]+');
    //Datatables
    Route::get('datatables', [
        'as' => 'storages.datatables',
        'uses' => 'StoragesController@datatables',
    ]);
});

/** ------------------------------------------
 *  Register Routes
 *  ------------------------------------------
 */
Route::get('register', 	[
    'as' => 'register',
    'uses' => 'RegisterController@index',
]);
Route::post('register', [
    'as' => 'register.do',
    'uses' => 'RegisterController@register',
]);
Route::get('verify', [
    'as' => 'verify',
    'uses' => 'RegisterController@verify',
]);

/** ------------------------------------------
 *  Auth Routes
 *  ------------------------------------------
 */
Route::get('login',  [
    'as' => 'login',
    'uses' => 'AuthController@index',
]);
Route::post('login', [
    'as' => 'login.do',
    'uses' => 'AuthController@login',
]);
Route::get('logout', [
    'as' => 'logout',
    'uses' => 'AuthController@logout',
]);

/** ------------------------------------------
 *  Password reminder Routes
 *  ------------------------------------------
 */
Route::controller('password', 'RemindersController');

/** ------------------------------------------
 *  Account Routes
 *  ------------------------------------------
 */
Route::group(array('before' => 'auth'), function () {
    Route::controller('account', 'AccountController');
});

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function () {
    // User Management
    Route::controller('users', 'AdminUsersController');
});
