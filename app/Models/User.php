<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'wallet_id',
        'email_verified_at',
        'banned_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'user_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id', 'id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id', 'id');
    }
}
