<?php

namespace App\Models\account\Traits;

use App\Models\transaction\Transaction;

/**
 * Class AccountRelationship
 */
trait AccountRelationship
{
     public function transactions()
    {
        return $this->hasMany('App\Models\transaction\Transaction','account_id')->withoutGlobalScopes();
    }

          public function amount()
          {
              return $this->hasMany(Transaction::class, 'account_id');
          }

}
