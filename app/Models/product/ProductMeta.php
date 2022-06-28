<?php

namespace App\Models\product;

use App\Models\ModelTrait;
use App\Models\product\Traits\ProductMetaRelationship;
use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model
{
        use ModelTrait,
    	ProductMetaRelationship {
            // ProductAttribute::getEditButtonAttribute insteadof ModelTrait;
        }
     protected $table = 'product_meta';

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

}
