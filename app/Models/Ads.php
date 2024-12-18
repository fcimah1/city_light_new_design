<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;

    protected $with = ['ads_translation'];

        public function getTranslation($field = '', $lang = false){
            $lang = $lang == false ? App::getLocale() : $lang;
            $ads_translation = $this->ads_translation->where('lang', $lang)->first();
            return $ads_translation != null ? $ads_translation->$field : $this->$field;
        }
    
    public function ads_translation()
    {
        return $this->hasMany(AdsTranslation::class);
    }
}
