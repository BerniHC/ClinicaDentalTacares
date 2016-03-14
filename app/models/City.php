<?php
class City extends Eloquent
{
    protected $table = 'city';

    public $timestamps = false;
    protected $softDelete = true;

    // Relation Estate
    public function estate()
    {
        return $this->belongsTo('Estate')->withTrashed();
    }
}
