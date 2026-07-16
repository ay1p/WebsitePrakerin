<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrakerinProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nisn',
        'school',
        'department',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
