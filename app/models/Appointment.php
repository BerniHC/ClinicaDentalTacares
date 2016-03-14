<?php
class Appointment extends Eloquent
{
    protected $table = 'appointment';
    
    public $timestamps = true;
    protected $softDelete = true;
    
    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::deleted(function($appointment) {
            $appointment->schedule()->delete();
        });
        
        static::restored(function($appointment) {
            $appointment->schedule()->restore();
        });
    } 

    // Relation Patient
    public function patient()
    {
        return $this->belongsTo('Patient')->withTrashed();
    }
    
    // Relation Doctor
    public function doctor()
    {
        return $this->belongsTo('User')->withTrashed();
    }
    
    // Relation Category
    public function category()
    {
        return $this->belongsTo('Category')->withTrashed();
    }
    
    // Relation Status
    public function status()
    {
        return $this->belongsTo('Metatype')->withTrashed();
    }
    
    // Relation Schedule
    public function schedule()
    {
        return $this->belongsTo('Schedule')->withTrashed();
    }
    
    // Relation Treatments
    public function treatments()
    {
        return $this->belongsToMany('Treatment')
            ->withPivot("amount", "observation");
    }

}
