<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

      protected $table = 'companies';

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
     * Guarded fields of model
     * @var array
     */
    protected $guarded = [
        'id'
    ];

        public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


    public function getThemeLogoAttribute()
    {
        if (!$this->attributes['theme_logo']) {
            return 'default_theme.png';
        }
        return $this->attributes['theme_logo'];
    }
        public function getLogoAttribute()
    {
        if (!$this->attributes['logo']) {
            return 'default.png';
        }
        return $this->attributes['logo'];
    }
            public function getIconAttribute()
    {
        if (!$this->attributes['icon']) {
            return 'favicon.ico';
        }
        return $this->attributes['icon'];
    }
}
