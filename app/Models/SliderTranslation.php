<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SliderTranslation extends Model
{
    use HasFactory;
    protected $table = 'slider_translation';
    protected $fillable = ['slider_id', 'photo', 'locale'];
    public function slider() : BelongsTo 
    {
        return $this->belongsTo(Slider::class);
    }
}
