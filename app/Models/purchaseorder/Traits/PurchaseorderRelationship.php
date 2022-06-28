<?php

namespace App\Models\purchaseorder\Traits;

/**
 * Class PurchaseorderRelationship
 */
trait PurchaseorderRelationship

{
         public function customer()
    {
        return $this->belongsTo('App\Models\supplier\Supplier','supplier_id')->withoutGlobalScopes();
    }
       public function supplier()
    {
        return $this->belongsTo('App\Models\supplier\Supplier')->withoutGlobalScopes();
    }



     public function products()
    {
        return $this->hasMany('App\Models\items\PurchaseItem','bill_id')->withoutGlobalScopes();
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
        return $this->hasMany('App\Models\transaction\Transaction','bill_id')->where('relation_id','=',9)->withoutGlobalScopes();
    }

    public function attachment()
    {
        return $this->hasMany('App\Models\items\MetaEntry','rel_id')->where('rel_type','=',9)->withoutGlobalScopes();
    }

}
