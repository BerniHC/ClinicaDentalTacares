<?php
class Schedule extends Eloquent
{
    protected $table = 'schedule';
    
    public $timestamps = false;
    protected $softDelete = true;

    // Get Title
    public function title() {
        return count($this->appointment) ? $this->appointment->patient->person->partialname() : $this->event->subject;
    }
    
    // Get Type
    public function type() {
        return count($this->appointment) ? 'appointment' : 'event';
    }
    
    // Get Description
    public function description() {
        return count($this->appointment) ? $this->appointment->observations : $this->event->description;
    }

    // Get URL
    public function url() {
        return count($this->appointment) ? URL::action('appointment-view', array($this->appointment->id)) : URL::route('event-view', array($this->event->id));
    }
    
    // Get Duration
    public function duration() {
        if($this->start_datetime == $this->end_datetime)
            return 'Todo el día';
        
        $result = '';

        $duration = date_diff( new DateTime($this->start_datetime), new DateTime($this->end_datetime) );
        $days = $duration->format('%a');
        $hrs = $duration->format('%h');
        $mins = $duration->format('%i');

        if($days != '0')
            $result .= $days . ' día(s) ';
            
        if($hrs != '0')
            $result .= $hrs . ' hora(s) ';

        if($mins != '0')
            $result .= $mins . ' minuto(s) ';

        return $result;
    }

    // Relation Event
    public function event()
    {
        return $this->hasOne('EventCal')->withTrashed();
    }
    
    // Relation Appointment
    public function appointment()
    {
        return $this->hasOne('Appointment')->withTrashed();
    }
    
}
