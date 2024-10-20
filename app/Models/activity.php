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
        'location',
        'food_and_drinks_available',
        'description',
        'start_date',
        'end_date',
        'cost',
        'date',
        'image',
        'min_participants',
        'max_participants',
        'is_for_covadis_members',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // The attributes that should be cast to native types
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'date' => 'datetime',
        'is_for_covadis_members' => 'boolean',
    ];
}
