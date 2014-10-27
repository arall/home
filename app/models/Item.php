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
        'name' => 'required|unique:items',
        'type_id' => 'required'
    ];

    protected $fillable = ['type_id', 'name', 'barcode', 'kcal', 'quantity'];

    public function ingredients()
    {
        return $this->belongsToMany('Ingredient', 'ingredient_item', 'item_id', 'ingredient_id')->withTimestamps();
    }

    public function storages()
    {
        return $this->belongsToMany('Storage', 'item_storage', 'item_id', 'storage_id')->withPivot('quantity', 'price')->withTimestamps();
    }

    public function type()
    {
        return $this->hasOne('ItemType', 'id', 'type_id');
    }

    public function getCountAttribute()
    {
        $rel = $this->storages()->selectRaw('sum(item_storage.quantity) as total');
        if (count($rel)) {
            $first = $rel->first();
            if (is_object($first)) {
                return $first->total;
            }
        }

        return 0;
    }

    public function getUnityPrice($userId = null)
    {
        $query = DB::table('item_storage')
            ->selectRaw('(sum(price) / sum(quantity)) as price')
            ->where('price', '>', '0')
            ->where('quantity', '>', '0')
            ->where('item_id', $this->id);
        if ($userId) {
            $query->leftJoin('storages', 'storages.id', '=', 'item_storage.storage_id')
                ->where('storages.user_id', $userId);
        }

        return round($query->first()->price, 2);
    }

    public function getCurrentStoragesAttribute()
    {
        return $this->storages()
            ->selectRaw('sum(item_storage.quantity) as total, storages.name as name')
            ->orderBy('total','desc')
            ->groupBy('storage_id')
            ->having('total', '>', 0)
            ->get();

        return 0;
    }

    public function scopeMine($query)
    {
        return $query->whereHas('storages', function ($q) {
            $q->where('user_id', Auth::user()->id);
        });
    }
}
