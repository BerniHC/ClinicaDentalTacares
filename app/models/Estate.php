<?php
class Estate extends Eloquent
{
    protected $table = 'estate';

    public $timestamps = false;
    protected $softDelete = true;

    // Relation Cities
    public function cities()
    {
        return $this->hasMany('City');
    }

}
