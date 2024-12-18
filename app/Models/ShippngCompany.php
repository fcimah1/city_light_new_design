<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippngCompany extends Model
{
    use HasFactory;

    protected $with = ['shippng_company'];

    public function shippng_company()
    {
        return $this->hasMany(ShippngCompanyTranslation::class);
    }

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $shippng_company = $this->shippng_company->where('lang', $lang)->first();
        return $shippng_company != null ? $shippng_company->$field : $this->$field;

    }
}
