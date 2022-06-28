<?php

namespace App\Models\hrm\Traits;


use App\Models\Access\Permission\Permission;
use App\Models\Access\Permission\PermissionRole;
use App\Models\Access\Permission\PermissionUser;
use App\Models\Access\Role\Role;
use App\Models\Access\User\UserProfile;
use App\Models\employee\RoleUser;
use App\Models\hrm\HrmMeta;
use App\Models\project\Project;
use App\Models\quote\Quote;
use App\Models\transaction\Transaction;

/**
 * Class HrmRelationship
 */
trait HrmRelationship
{

    public function role()
    {
        return $this->hasOneThrough(Role::class, RoleUser::class, 'user_id', 'id', 'id', 'role_id')->withoutGlobalScopes();
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\invoice\Invoice', 'user_id');
    }

        public function quotes()
    {
        return $this->hasMany(Quote::class, 'user_id');
    }

            public function projects()
    {
      //  return $this->hasMany(Project::class, 'user_id');
    }


    public function amount()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

        public function payroll()
    {
        return $this->hasMany(Transaction::class, 'payer_id','id')->where('relation_id','=',3);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    public function meta()
    {
        return $this->hasOne(HrmMeta::class, 'user_id');
    }

    public function user_associated_permission()
    {
        //user current permission
        //  return $this->hasManyThrough(Permission::class, PermissionUser::class, 'permission_id','id', 'id','user_id')->withoutGlobalScopes();

        return $this->belongsToMany(Permission::class, PermissionUser::class, 'user_id', 'permission_id', 'id', 'id')->withoutGlobalScopes();
    }

    public function role_associated_permission()
    {
        //user role id available permission
        //  return $this->hasManyThrough(Permission::class, PermissionUser::class, 'permission_id','id', 'id','user_id')->withoutGlobalScopes();

        return $this->belongsToMany(PermissionRole::class, RoleUser::class, 'user_id', 'role_id', 'id', 'role_id')->withoutGlobalScopes();
    }

    public function created_by_user()
    {
        return $this->hasOne(Self::class, 'created_by');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, PermissionUser::class, 'user_id', 'permission_id', 'id', 'id')->withoutGlobalScopes();
    }


}
