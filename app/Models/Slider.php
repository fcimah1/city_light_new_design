<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
  //
  public function slider_translation()
  {
    return $this->hasMany('App-Mode');
  }

  protected $with = ['slider_translations'];

  public function getTranslation($field = '', $lang = false)
  {
    $lang = $lang == false ? App::getLocale() : $lang;
    $slider_translations = $this->slider_translations->where('lang', $lang)->first();
    return $slider_translations != null ? $slider_translations->$field : $this->$field;
  }

  public function slider_translations()
  {
    return $this->hasMany(SliderTranslation::class);
  }
}