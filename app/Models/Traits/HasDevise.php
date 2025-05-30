<?php

namespace App\Models\Traits;

use App\Models\Bases\Devise;


trait HasDevise
{
    public function getDevise($value = null)
    {
        $devise = new Devise($value);
        $devise->convert($devise->rateUser());
        return $devise;
    }
    
    public function setDevise($value = null)
    {
        $devise = new Devise($value);
        $devise->setCurrent($devise->rateUser());
        return $devise->base();
    }

    public function getPrixAttribute($value = null)
    {
        return $this->getDevise($value);
    }

    public function setPrixAttribute($value)
    {
        $this->attributes['prix'] = (string) $this->setDevise($value);
    }
    public function getSalaireAttribute($value = null)
    {
        return $this->getDevise($value);
    }

    public function setSalaireAttribute($value)
    {
        $this->attributes['salaire'] = (string) $this->setDevise($value);
    }
}
