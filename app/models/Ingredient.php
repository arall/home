<?php

class Ingredient extends \Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ingredients';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = ['name'];

    public function items()
    {
        return $this->belongsToMany('Item');
    }

}
