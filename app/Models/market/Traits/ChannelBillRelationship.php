<?php

namespace App\Models\market\Traits;


use App\Models\invoice\Invoice;
use App\Models\market\ChannelBill;
use App\Models\market\SalesChannel;
use App\Models\purchaseorder\Purchaseorder;

/**
 * Class CustomerRelationship
 */
trait ChannelBillRelationship
{


       public function bill()
    {
        return $this->belongsTo(SalesChannel::class,'c_id','id')->withoutGlobalScopes();
    }

        public function invoice()
    {
        return $this->hasOne(Invoice::class,'id','bill_id')->withoutGlobalScopes();
    }


        public function purchaseorders()
    {
        return $this->hasOne(Purchaseorder::class,'id','bill_id')->withoutGlobalScopes();
    }






}
