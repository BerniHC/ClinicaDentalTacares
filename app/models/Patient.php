<?php
class Patient extends Eloquent 
{
	protected $table = 'patient';
    
    public $timestamps = true;
    protected $softDelete = true;
    
    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::deleted(function($parent)
        {
            $parent->person()->delete();
            $parent->appointments()->delete();
        });
        
        static::restored(function($parent)
        {
            $parent->person()->restore();
            $parent->appointments()->restore();
        });
    } 

    // Relation Person
    public function person()
    {
        return $this->belongsTo('Person')->withTrashed();
    }

    // Relation Type
    public function type()
    {
        return $this->belongsTo('Metatype')->withTrashed();
    }
    
    // Relation Appointments
    public function appointments()
    {
        return $this->hasMany('Appointment');
    }
    
    // Relation Treatments
    public function treatments()
    {
        return $this->belongsToMany('Appointment', 'appointment_treatment', 'appointment_id', 'treatment_id');
    }

}