<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id', 'name', 'surname'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
