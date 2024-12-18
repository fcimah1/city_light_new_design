<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'link',
        'icon',
        'is_active', // 0 = inactive, 1 = active
        'header_tag',
        'footer_tag',
    ];
}
