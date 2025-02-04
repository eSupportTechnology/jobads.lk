<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    protected $table = 'duration';
    protected $fillable = [
        'duration',
        'type', 
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function bannerPackages()
    {
        return $this->hasMany(BannerPackage::class);
    }
}
