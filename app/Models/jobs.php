<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Application; 
use App\Models\Companies;

class Jobs extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'job_listings';
    protected $fillable = ['name', 'description', 'salary', 'location', 'company_id', 'user_id'];

    public function company() {
        return $this->belongsTo(Companies::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function applications() {
        return $this->hasMany(Application::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        });

        $query->when($filters['location'] ?? null, function ($query, $location) {
            $query->where('location', 'like', '%' . $location . '%');
        });

        $query->when($filters['min_salary'] ?? null, function ($query, $salary) {
            $query->where('salary', '>=', $salary);
        });
    }
}