<?php

namespace App\Models\market\Traits;


use App\Models\invoice\Invoice;
use App\Models\market\ChannelBill;

/**
 * Class CustomerRelationship
 */
trait SalesChannelRelationship
{

     public function invoices_i()
    {
        return $this->hasOne('App\Models\invoice\Invoice','id','bill_id')->withoutGlobalScopes();
    }

      public function invoicess()
    {
        //second key == invoices

        return $this->hasManyThrough(Invoice::class,ChannelBill::class,'c_id','id','id','bill_id');
    }

        public function invoices()
    {
        //second key == invoices

        return $this->belongsToMany(ChannelBill::class,Invoice::class,'cid','id','c_id','bill_id');
    }

       public function invoice()
    {
        return $this->hasOne(ChannelBill::class,'id','c_id')->withoutGlobalScopes();
    }





}
