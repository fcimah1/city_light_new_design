<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['ads_id', 'name', 'banner', 'link', 'locale'];
    public function ads()  {
        return $this->belongsTo(Ads::class);
        
    }
}
