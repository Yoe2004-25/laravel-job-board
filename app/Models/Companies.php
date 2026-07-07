<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Jobs;

class Companies extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name', 'number_employees', 'website_name', 'number_phone', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function jobs() {
        return $this->hasMany(Jobs::class);
    }
}