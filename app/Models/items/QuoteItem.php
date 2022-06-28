<?php

namespace App\Models\items;

use App\Models\items\Traits\InvoiceItemRelationship;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
     use InvoiceItemRelationship {
            // CustomfieldAttribute::getEditButtonAttribute insteadof ModelTrait;
        }
    protected $table = 'quote_items';

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
