<?php
class Address extends Eloquent
{
    protected $table = 'address';

    public $timestamps = false;
    protected $softDelete = true;

    // Relation Person
    public function person()
    {
        return $this->belongsTo('Person')->withTrashed();
    }
    
    // Relation State
    public function estate()
    {
        return $this->belongsTo('Estate')->withTrashed();
    }

    // Relation City
    public function city()
    {
        return $this->belongsTo('City')->withTrashed();
    }

}