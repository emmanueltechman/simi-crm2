<?php

namespace App\Models\order\Traits;

/**
 * Class OrderRelationship
 */
trait OrderRelationship
{
       public function customer()
    {
        return $this->hasOne('App\Models\customer\Customer','id','customer_id')->withoutGlobalScopes();
    }

           public function supplier()
    {
        return $this->hasOne('App\Models\supplier\Supplier','id','customer_id')->withoutGlobalScopes();
    }

     public function products()
    {
        return $this->hasMany('App\Models\items\OrderItem')->withoutGlobalScopes();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User')->withoutGlobalScopes();
    }
    public function term()
    {
        return $this->belongsTo('App\Models\term\Term')->withoutGlobalScopes();
    }
     public function transactions()
    {
        return $this->hasMany('App\Models\transaction\Transaction','bill_id')->where('relation_id','=',5)->withoutGlobalScopes();
    }

    public function attachment()
    {
        return $this->hasMany('App\Models\items\MetaEntry','rel_id')->where('rel_type','=',5)->withoutGlobalScopes();
    }

}
