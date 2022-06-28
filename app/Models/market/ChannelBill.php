<?php

namespace App\Models\market;

use App\Models\invoice\Traits\SalesChannelAttribute;

use App\Models\market\Traits\ChannelBillRelationship;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class ChannelBill extends Model
{

        use ModelTrait,ChannelBillRelationship {
        }

    protected $table = 'channel_bill';


    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * Default values for model fields
     * @var array
     */
    protected $attributes = [

    ];

    /**
     * Dates
     * @var array
     */
    public $timestamps = false;

    /**
     * Guarded fields of model
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Constructor of Model
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
    protected static function boot()
    {
            parent::boot();
           // static::addGlobalScope('ins', function($builder){
           // $builder->where('ins', '=', auth()->user()->ins);
   // });
    }
}
