<?php

namespace App\Models\customer\Traits;

use App\Models\customfield\Customfield;
use App\Models\transaction\Transaction;

/**
 * Class CustomerRelationship
 */
trait CustomerRelationship
{
    public function group()
    {
        return $this->hasMany('App\Models\customergroup\CustomerGroupEntry');
    }

    public function primary_group()
    {
        return $this->hasOne('App\Models\customergroup\CustomerGroupEntry')->oldest();
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\invoice\Invoice')->orderBy('id','DESC');
    }

       public function amount()
        {
             return $this->hasMany(Transaction::class,'payer_id');
        }

           public function transactions()
    {
        return $this->hasMany('App\Models\transaction\Transaction','payer_id')->where('relation_id','=',0)->orWhere('relation_id','=',21)->withoutGlobalScopes();
    }
}
