<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use App\Notifications\CustomVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'is_verified',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function watchlist()
    {
        return $this->belongsToMany(Auction::class, 'watchlist')->withTimestamps();
    }

    public function purchases()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function sales()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class);
    }

    // Spatie rolleri kullanıyoruz artık ama eski
    // isSeller() / isAdmin() helper'ları da bırakıyoruz
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isSeller(): bool
    {
        return $this->hasRole('seller');
    }

    public function isBuyer(): bool
    {
        return $this->hasRole('buyer');
    }

    public function isSellerApproved(): bool
    {
        return $this->hasRole('seller')
            && $this->sellerProfile
            && $this->sellerProfile->verification_status === 'approved';
    }

    public function getProfileImgAttribute(): string
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=009ef7&color=fff&size=160';
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_verified'       => 'boolean',
            'password'          => 'hashed',
        ];
    }
}