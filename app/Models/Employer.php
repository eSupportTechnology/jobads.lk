<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'email',
        'password',
        'contact_details',
        'business_info',
        'job_posting_settings',
        'is_active',
        'logo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}

