<?php

class ItemType extends \Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'item_types';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = ['name'];

}
