<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function attachments(): HasMany
    {
        return $this->hasMany(ActivityAttachment::class);
    }

    public function getAttachmentPathsAttribute(): array
    {
        $paths = $this->attachments->pluck('path')->all();

        if (empty($paths) && $this->attachment_path) {
            return [$this->attachment_path];
        }

        return $paths;
    }
}
