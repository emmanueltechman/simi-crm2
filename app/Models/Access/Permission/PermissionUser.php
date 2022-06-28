<?php

namespace App\Models\Access\Permission;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
     protected $table='permission_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $attributes = [

    ];
    public $timestamps = false;
}
