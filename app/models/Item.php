<?php

class Item extends \Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'items';

    public static $rules = [
        'name' => 'required',
        'type_id' => 'required'
    ];

    protected $fillable = ['type_id', 'name', 'barcode', 'kcal', 'quantity'];

    public function ingredients()
    {
        return $this->belongsToMany('Ingredient');
    }

    public function type()
    {
        return $this->hasOne('ItemType', 'id', 'type_id');
    }

}
