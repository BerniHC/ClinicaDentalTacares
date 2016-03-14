<?php

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $table = 'permission';

    public $timestamps = false;
    protected $softDelete = true;

    // Relation Roles
    public function roles()
    {
        return $this->belongsToMany('Role', 'permission_role');
    }
}