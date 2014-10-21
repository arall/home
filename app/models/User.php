<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    /**
     * Mass assigned attributes.
     *
     * @var array
     */
    protected $fillable = array('username', 'email', 'password');

    /**
     * The default attributes values
     *
     * @var array
     */
    protected $attributes = array(
       'status' => 1,
    );

    /**
     * Rules
     * @var array
     */
    public static $rules = array(
        'username'  => 'required|min:5|alpha_dash|unique:users,username,{ignore_id}',
        'email'     => 'required|email|unique:users,email,{ignore_id}',
        'password'  => 'required|min:6|confirmed',
    );

    /**
     * Triggers
     */
    public static function boot()
    {
        parent::boot();

        // Creating
        static::creating(function ($model) {
            // Confirmation code
            $model->confirmation_code = str_random(30);
        });
    }

    /**
     * Allways set hashed password
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Role relation
     */
    public function role()
    {
        return $this->hasOne('Role');
    }

    /**
     * Storages relation
     */
    public function storages()
    {
        return $this->hasMany('Storage');
    }
}
