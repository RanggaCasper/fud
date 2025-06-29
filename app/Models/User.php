<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Restaurant\Claim;
use App\Models\Restaurant\Favorite;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username', 
        'email',
        'password',
        'google_id',
        'avatar',
        'phone',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function restaurantClaim()
    {
        return $this->hasOne(Claim::class, 'user_id');
    }

    public function owned()
    {
        return $this->hasOne(Claim::class, 'user_id')->where('status', 'approved');
    }

    public function restaurantClaims()
    {
        return $this->hasMany(Claim::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function isGoogleConnected()
    {
        return $this->socialAccounts()->where('social_provider', 'google')->exists();
    }

    public function isFacebookConnected()
    {
        return $this->socialAccounts()->where('social_provider', 'facebook')->exists();
    }

    public function hasRole(string $role): bool
    {
        return $this->role && $this->role->name === $role;
    }
}
