<?php

namespace App\Models\Gateway\Traits;

/**
 * Class UsergatewayentryRelationship
 */
trait UsergatewayentryRelationship
{
    public function gateway()
    {
        return $this->hasOne('App\Models\Company\UserGateway','id','user_gateway_id')->withoutGlobalScopes();
    }
}
