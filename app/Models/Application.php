<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Jobs;
use App\Models\User;

class Application extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['title', 'cv', 'status', 'user_id', 'job_id'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function job() {
        return $this->belongsTo(Jobs::class);
    }
}