<?php

namespace App\Models\Company\Traits;

/**
 * Class CustomerRelationship
 */
trait ConfigMetaRelationship
{
      public function currency()
    {
        return $this->hasOne('App\Models\currency\Currency','id','feature_value')->withoutGlobalScopes();
    }

        public function warehouse()
    {
        return $this->hasOne('App\Models\warehouse\Warehouse','id','feature_value')->withoutGlobalScopes();
    }


    public function discount_tax()
    {
        return $this->hasOne('App\Models\additional\Additional','id','feature_value')->withoutGlobalScopes();
    }
       public function ship_tax()
    {
        return $this->hasOne('App\Models\additional\Additional','id','value2')->withoutGlobalScopes();
    }

      public function payment_account()
    {
        return $this->hasOne('App\Models\account\Account','id','feature_value')->withoutGlobalScopes();
    }


}
