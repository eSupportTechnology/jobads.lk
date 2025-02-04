<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'duration_id',
        'price_lkr',
        'price_usd',
    ];

    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }
}