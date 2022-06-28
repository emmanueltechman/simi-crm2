<?php

namespace App\Models\product;

use Illuminate\Database\Eloquent\Model;
use App\Models\product\Traits\ProductVariationRelationship;

class ProductVariation extends Model
{
        use ProductVariationRelationship{}

         protected $table = 'product_variations';

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
            $builder->where('product_variations.ins', '=', auth()->user()->ins);
    });
    }



}
