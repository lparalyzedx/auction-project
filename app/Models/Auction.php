<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'description',
        'starting_price', 'reserve_price', 'current_price', 'buy_now_price',
        'min_bid_increment', 'starts_at', 'ends_at', 'status',
        'is_featured', 'condition', 'location', 'view_count',
    ];

    protected $casts = [
        'starts_at'        => 'datetime',
        'ends_at'          => 'datetime',
        'is_featured'      => 'boolean',
        'starting_price'   => 'decimal:2',
        'current_price'    => 'decimal:2',
        'reserve_price'    => 'decimal:2',
        'buy_now_price'    => 'decimal:2',
        'min_bid_increment'=> 'decimal:2',
    ];

    // İlişkiler
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(AuctionImage::class)->orderBy('sort_order');
    }

    public function coverImage()
    {
        return $this->hasOne(AuctionImage::class)->where('is_cover', true);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class)->orderByDesc('amount');
    }

    public function highestBid()
    {
        return $this->hasOne(Bid::class)->orderByDesc('amount');
    }

    public function watchers()
    {
        return $this->belongsToMany(User::class, 'watchlist')->withTimestamps();
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    // Helper metodlar
    public function isActive(): bool
    {
        return $this->status === 'active'
            && now()->between($this->starts_at, $this->ends_at);
    }

    public function isEnded(): bool
    {
        return $this->status === 'ended' || now()->isAfter($this->ends_at);
    }

    public function nextMinimumBid(): float
    {
        return (float) $this->current_price + (float) $this->min_bid_increment;
    }

    public function reserveMet(): bool
    {
        if (! $this->reserve_price) return true;
        return $this->current_price >= $this->reserve_price;
    }

    public function getRemainingTimeAttribute(): string
    {
        if ($this->isEnded()) return 'Sona erdi';
        return now()->diffForHumans($this->ends_at, ['parts' => 2]);
    }
}