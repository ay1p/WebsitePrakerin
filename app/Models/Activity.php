<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'activity',
        'attachment_path',
        'submitted_at',
    ];

    /**
     * Get the user that logged the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
