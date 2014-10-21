<?php

class Storage extends \Eloquent
{
    public static $rules = [
        'name' => 'required'
    ];

    protected $table = 'storages';

    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function items()
    {
        return $this->belongsToMany('Item', 'item_storage', 'storage_id', 'item_id')->withPivot('quantity', 'price')->withTimestamps();
    }

    public function getItemsCountAttribute()
    {
        $items = $this->items()->selectRaw('sum(item_storage.quantity) as total');
        if (count($items)) {
            $first = $items->first();
            if (is_object($first)) {
                return $first->total;
            }
        }

        return 0;
    }

    public function getItemsWorthAttribute()
    {
        $items = $this->items()->selectRaw('sum(item_storage.price) as total');
        if (count($items)) {
            $first = $items->first();
            if (is_object($first)) {
                return $first->total;
            }
        }

        return 0;
    }

    public function getCurrentItemsAttribute()
    {
        return $this->items()
            ->selectRaw('sum(item_storage.quantity) as total, items.name as name')
            ->orderBy('total','desc')
            ->groupBy('item_id')
            ->having('total', '>', 0)
            ->get();

        return 0;
    }

}
