<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activities';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'date',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'date' => 'date',
    ];
}
