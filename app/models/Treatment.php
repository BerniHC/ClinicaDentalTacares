<?php
class Treatment extends Eloquent
{
    protected $table = 'treatment';
    
    public $timestamps = false;
    protected $softDelete = true;
    
    // Relation Category
    public function category()
    {
        return $this->belongsTo('Category')->withTrashed();
    }
    
    // Relation Appointments
    public function appointments()
    {
        return $this->belongsToMany('Appointment');
    }

}