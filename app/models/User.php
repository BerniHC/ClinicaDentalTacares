<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;
use LaravelBook\Ardent\Ardent;

class User extends Ardent implements UserInterface, RemindableInterface 
{
    use HasRole;

	protected $table = 'user';
    
    public $timestamps = true;
    protected $softDelete = true;

    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::deleted(function($parent)
        {
            $parent->person()->delete();
        });
        
        static::restored(function($parent)
        {
            $parent->person()->restore();
        });
    } 

    // Relation Person
    public function person()
    {
        return $this->belongsTo('Person')->withTrashed();
    }

    // Relation Roles
    public function roles()
    {
        return $this->belongsToMany('Role', 'user_role')->withTrashed();
    }

	/**
	 * The attributes excluded from the model's JSON form.
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}
