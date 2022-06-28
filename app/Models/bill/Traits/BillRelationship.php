<?php

namespace App\Models\bill\Traits;

/**
 * Class InvoiceRelationship
 */
trait BillRelationship
{

      public function customer()
    {
        return $this->belongsTo('App\Models\customer\Customer')->withoutGlobalScopes();
    }

     public function products()
    {
        return $this->hasMany('App\Models\items\InvoiceItem','invoice_id')->withoutGlobalScopes();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User');
    }
    public function term()
    {
        return $this->belongsTo('App\Models\term\Term')->withoutGlobalScopes();
    }
     public function transactions()
    {
        return $this->hasMany('App\Models\transaction\Transaction','bill_id')->where('relation_id','=',0)->withoutGlobalScopes();
    }


}
