<?php

namespace App\Models\invoice\Traits;

use App\Models\project\Project;
use App\Models\project\ProjectRelations;

/**
 * Class InvoiceRelationship
 */
trait DraftRelationship
{

      public function customer()
    {
        return $this->belongsTo('App\Models\customer\Customer')->withoutGlobalScopes();
    }

     public function products()
    {
        return $this->hasMany('App\Models\items\DraftItem','invoice_id')->withoutGlobalScopes();
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
        return $this->hasMany('App\Models\transaction\Transaction','bill_id')->where('relation_id','=',0)->withoutGlobalScopes();
    }

    public function attachment()
    {
        return $this->hasMany('App\Models\items\MetaEntry','rel_id')->where('rel_type','=',1)->withoutGlobalScopes();
    }

            public function project()
    {
         return $this->belongsTo(ProjectRelations::class, 'id',  'rid')->where('related', '=', 7);
    }


}
