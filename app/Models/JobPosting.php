<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'subcategory_id',
        'location',
        'country',
        'salary_range',
        'image',
        'requirements',
        'employer_id',
        'admin_id',
        'creator_id',
        'closing_date',
        'approved_date',
        'rejected_date',
        'status',
        'payment_method',
        'rejection_reason',
        'job_id',
        'is_active',
        'package_id',
        'view_count',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
