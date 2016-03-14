<?php
use LaravelBook\Ardent\Ardent;

class Person extends Ardent
{
    protected $table = 'person';
    
    public $timestamps = false;
    protected $softDelete = true;

    // Get Fullname
    public function fullname()
    {
        return $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname;
    }
    
    // Get Partial Name
    public function partialname()
    {
        return $this->firstname . ' ' . $this->middlename;
    }
    
    // Get Surnames
    public function surnames()
    {
        return $this->middlename . ' ' . $this->lastname;
    }

    // Get Age
    public function age()
    {
        list($y, $m, $d) = explode("-", $this->birthdate);
        $year = date("Y") - $y;
        $month = date("m") - $m;
        $day = date("d") - $d;
        if ($day < 0 || $month < 0)
            $year--;
        return $year . ' años';
    }
    
    // Relation Document Type
    public function document()
    {
        return $this->hasOne('Metatype', 'id', 'document_type_id')->withTrashed();
    }

    // Relation Gender
    public function gender()
    {
        return $this->hasOne('Metatype', 'id', 'gender_id')->withTrashed();
    }

    // Relation User
    public function user()
    {
        return $this->hasOne('User')->withTrashed();
    }
    
    // Relation Patient
    public function patient()
    {
        return $this->hasOne('Patient')->withTrashed();
    }

    // Relation Addresses
    public function addresses()
    {
        return $this->hasMany('Address');
    }

    // Relation Telephones
    public function telephones()
    {
        return $this->hasMany('Telephone');
    }
}