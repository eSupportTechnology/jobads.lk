<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'message',
        'user_id',
        'employer_id',
        'company_mail',
        'cv_path',
        'job_posting_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
}

