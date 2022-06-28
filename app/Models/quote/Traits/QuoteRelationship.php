<?php

namespace App\Models\quote\Traits;

/**
 * Class QuoteRelationship
 */
trait QuoteRelationship
{
       public function customer()
    {
        return $this->belongsTo('App\Models\customer\Customer')->withoutGlobalScopes();
    }

     public function products()
    {
        return $this->hasMany('App\Models\items\QuoteItem')->withoutGlobalScopes();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User')->withoutGlobalScopes();
    }
    public function term()
    {
        return $this->belongsTo('App\Models\term\Term')->withoutGlobalScopes();
    }


    public function attachment()
    {
        return $this->hasMany('App\Models\items\MetaEntry','rel_id')->where('rel_type','=',4)->withoutGlobalScopes();
    }

}
