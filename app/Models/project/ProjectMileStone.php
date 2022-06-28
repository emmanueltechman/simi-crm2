<?php

namespace App\Models\project;

use App\Models\ModelTrait;
use App\Models\project\Traits\MileStoneRelationship;
use Illuminate\Database\Eloquent\Model;

class ProjectMileStone extends Model
{
        use ModelTrait,
    	MileStoneRelationship{}
    protected $table = 'project_milestones';

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
