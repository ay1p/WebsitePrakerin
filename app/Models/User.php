<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the prakerin profile associated with the user.
     */
    public function prakerinProfile()
    {
        return $this->hasOne(PrakerinProfile::class);
    }

    /**
     * Get the activities logged by the user.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a prakerin student.
     */
    public function isPrakerin(): bool
    {
        return $this->role === 'prakerin';
    }

    /**
     * Check if user is a validated prakerin student.
     */
    public function isApprovedPrakerin(): bool
    {
        return $this->isPrakerin() && $this->prakerinProfile && $this->prakerinProfile->status === 'approved';
    }
}
