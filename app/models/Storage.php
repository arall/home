<?php

class Storage extends \Eloquent
{
        /**
     * DB Table
     *
     * @var string
     */
    protected $table = 'storages';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * User Relation
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * Items relation
     *
     * @return array Items
     */
    public function items()
    {
        return $this->belongsToMany('Item', 'item_storage', 'storage_id', 'item_id')->withPivot('quantity', 'price')->withTimestamps();
    }

    /**
     * Storage current Item count accessor
     *
     * @return integer
     */
    public function getItemsCountAttribute()
    {
        $items = $this->items()->select(DB::raw('sum(item_storage.quantity) as total'));
        if (count($items)) {
            $first = $items->first();
            if (is_object($first)) {
                return $first->total;
            }
        }

        return 0;
    }

    /**
     * Storage current Item total worth accessor
     *
     * @return float
     */
    public function getItemsWorthAttribute()
    {
        $items = $this->items()->select(DB::raw('sum(item_storage.price) as total'));
        if (count($items)) {
            $first = $items->first();
            if (is_object($first)) {
                return $first->total;
            }
        }

        return 0;
    }

    /**
     * Storage current Item list accessor
     *
     * @return array Items
     */
    public function getCurrentItemsAttribute()
    {
        return $this->items()
            ->select(DB::raw('sum(item_storage.quantity) as total, items.name as name'))
            ->orderBy('total','desc')
            ->groupBy('item_id')
            ->having('total', '>', 0)
            ->get();

        return 0;
    }

    /**
     * Check if storage belongs to current logged user
     *
     * @return boolean
     */
    public function isMine()
    {
        return Auth::check() && $this->user->id == Auth::user()->id;
    }

    /**
     * Belongs to current user Scope
     *
     * @param  Query $query
     * @return Query
     */
    public function scopeMine($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('id', Auth::user()->id);
        });
    }

}
