<?php
    
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table = 'role';

    public $timestamps = false;
    protected $softDelete = true;

    // Relation Users
    public function users()
    {
        return $this->belongsToMany('User', 'user_role');
    }

    // Relation Permissions
    public function permissions()
    {
        return $this->belongsToMany('Permission', 'permission_role');
    }
}