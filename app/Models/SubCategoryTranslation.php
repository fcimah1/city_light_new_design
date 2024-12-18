<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryTranslation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'locale',
        'sub_category_id'
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    
}
