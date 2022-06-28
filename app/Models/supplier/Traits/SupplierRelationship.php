<?php

namespace App\Models\supplier\Traits;

use App\Models\transaction\Transaction;

/**
 * Class SupplierRelationship
 */
trait SupplierRelationship
{
  public function invoices()
    {
        return $this->hasMany('App\Models\purchaseorder\Purchaseorder');
    }

       public function amount()
        {
             return $this->hasMany(Transaction::class,'payer_id');
        }

            public function transactions()
    {
        return $this->hasMany('App\Models\transaction\Transaction','payer_id')->where('relation_id','=',9)->orWhere('relation_id','=',22)->withoutGlobalScopes();
    }
}
