<?php
class Metagroup extends Eloquent
{
    protected $table = 'metagroup';

    public $timestamps = false;
    protected $softDelete = true;
    
    // Relation Metatype
    public function metatypes()
    {
        return $this->hasMany('Metatype');
    }
}