<?php

namespace App\Models\hrm\Traits;

/**
 * Class HrmAttribute.
 */
trait HrmMetaAttribute
{

      public function setSalaryAttribute($value)
    {
            $this->attributes['salary'] = numberClean($value);
    }

      public function setHraAttribute($value)
    {
            $this->attributes['hra'] = numberClean($value);
    }

     public function setCommissionAttribute($value)
    {
          $this->attributes['commission'] = numberClean($value);
    }


        public function getSalaryAttribute($value)
    {
        return $this->attributes['salary'] = numberFormat($value);
    }


      public function getHraAttribute($value)
    {
          return  $this->attributes['hra'] = numberClean($value);
    }

          public function getCommissionAttribute($value)
    {
        return $this->attributes['commission'] = numberFormat($value);
    }

}
