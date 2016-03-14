<?php
class Metatype extends Eloquent
{
    protected $table = 'metatype';

    public $timestamps = false;
    protected $softDelete = true;
    
    // Relation Metagroup
    public function metagroup()
    {
        return $this->belongsTo('Metagroup')->withTrashed();
    }
}