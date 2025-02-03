<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerDetail extends Model
{
    //
    protected $fillable = [
        'email',
        'effective_date',
        'mbsize',
        'cbsize',
        'description_one',
        'description_two',
        'description_three',
    ];
}