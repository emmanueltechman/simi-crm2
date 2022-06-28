<?php

namespace App\Models\transaction\Traits;

use App\Models\hrm\Hrm;

/**
 * Class TransactionRelationship
 */
trait TransactionRelationship
{
      public function account()
    {
        return $this->belongsTo('App\Models\account\Account');
    }

        public function customer()
    {
        return $this->belongsTo('App\Models\customer\Customer','payer_id','id');
    }

            public function employee()
    {
        return $this->belongsTo(Hrm::class,'payer_id','id');
    }

         public function category()
    {
        return $this->belongsTo('App\Models\transactioncategory\Transactioncategory','trans_category_id','id');
    }
        public function invoice()
    {
        return $this->hasOne('App\Models\invoice\Invoice','id','bill_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User')->withoutGlobalScopes();
    }
}
