<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippngCompanyTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'shippng_company_id',
        'locale',
        'name',
        'logo',
    ];
    public function shippngCompany()
    {
        return $this->belongsTo(ShippngCompany::class);
    }
}
