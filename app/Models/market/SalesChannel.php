<?php

namespace App\Models\market;

use App\Models\items\Traits\RegisterRelationship;
use App\Models\market\Traits\SalesChannelAttribute;
use App\Models\market\Traits\SalesChannelRelationship;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class SalesChannel extends Model
{
            use ModelTrait,SalesChannelRelationship,SalesChannelAttribute {
        }
    protected $table = 'channel';

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
    protected $dates = [
        'created_at',
        'updated_at'
    ];

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
            static::addGlobalScope('ins', function($builder){
            $builder->where('ins', '=', auth()->user()->ins);
    });
    }
}
