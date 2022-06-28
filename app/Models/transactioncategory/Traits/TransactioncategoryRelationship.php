<?php

namespace App\Models\transactioncategory\Traits;

use App\Models\transaction\Transaction;

/**
 * Class TransactioncategoryRelationship
 */
trait TransactioncategoryRelationship
{
        public function amount()
        {
             return $this->hasMany(Transaction::class,'trans_category_id');
        }
}
