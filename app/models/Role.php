<?php

class Role extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * User Relation
     */
    public function users()
    {
        return $this->belongsTo("User");
    }
}
