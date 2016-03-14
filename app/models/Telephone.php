<?php
class Telephone extends Eloquent
{
    protected $table = 'telephone';

    public $timestamps = false;
    protected $softDelete = true;

    // Relation Person
    public function person()
    {
        return $this->belongsTo('Person')->withTrashed();
    }
}
