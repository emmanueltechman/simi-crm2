<?php

namespace App\Models\Company;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company\Traits\UserGatewayRelationship;
class UserGateway extends Model
{
       use ModelTrait, UserGatewayRelationship {
        // InvoiceAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

}
