<?php
class EventCal extends Eloquent
{
    protected $table = 'event';
    
    public $timestamps = true;
    protected $softDelete = true;
    
    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::deleted(function($event)
        {
            $event->schedule()->delete();
        });
        
        static::restored(function($appointment)
        {
            $event->schedule()->restore();
        });
    } 

    // Relation Priority
    public function priority()
    {
        return $this->belongsTo('Metatype')->withTrashed();
    }
    
    // Relation Recurrence Type
    public function recurrence_type()
    {
        return $this->belongsTo('Metatype')->withTrashed();
    }
    
    // Relation Schedule
    public function schedule()
    {
        return $this->belongsTo('Schedule')->withTrashed();
    }

}
