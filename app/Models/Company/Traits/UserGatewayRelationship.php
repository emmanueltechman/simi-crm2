<?php

namespace App\Models\Company\Traits;

/**
 * Class CustomerRelationship
 */
trait UserGatewayRelationship
{

      public function config()
    {
        return $this->hasOne('App\Models\Gateway\Usergatewayentry','user_gateway_id','id')->withoutGlobalScopes();
    }
}
