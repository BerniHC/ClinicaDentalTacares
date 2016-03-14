<?php
class Category extends Eloquent
{
    protected $table = 'category';
    
    public $timestamps = false;
    protected $softDelete = true;
    
    // Relation Cities
    public function cities()
    {
        return $this->hasMany('City');
    }
    
    // Relation Appointments
    public function appointments()
    {
        return $this->hasMany('Appointment');
    }

}