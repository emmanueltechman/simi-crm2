<?php

namespace App\Models\Access\User;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table='user_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'postal',
        'company',
        'contact',
        'tax_id',
    ];
}
