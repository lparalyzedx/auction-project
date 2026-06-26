<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Auction extends Model
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'user_id','category_id','title','slug','description',
        'starting_price','reserve_price','current_price','buy_now_price',
        'min_bid_increment','starts_at','ends_at','status',
        'is_featured','condition','location',
    ];

    protected $casts = [
        'starts_at'        => 'datetime',
        'ends_at'          => 'datetime',
        'starting_price'   => 'decimal:2',
        'current_price'    => 'decimal:2',
        'reserve_price'    => 'decimal:2',
        'buy_now_price'    => 'decimal:2',
        'min_bid_increment'=> 'decimal:2',
        'is_featured'      => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($m) {
            $m->slug         ??= Str::slug($m->title) . '-' . Str::random(5);
            $m->current_price ??= $m->starting_price;
        });
    }

    public function user()     { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function images()   { return $this->hasMany(AuctionImage::class)->orderBy('sort_order'); }
    public function cover()    { return $this->hasOne(AuctionImage::class)->where('is_cover', true); }
    public function bids()     { return $this->hasMany(Bid::class)->latest(); }
    public function watchlist(){ return $this->hasMany(Watchlist::class); }
    public function orders()   { return $this->hasMany(Order::class); }

    public function coverUrl(): string
    {
        return $this->cover?->path
            ? asset('storage/' . $this->cover->path)
            : asset('assets/media/placeholder.png');
    }

    public function displayPrice(): string
    {
        return number_format($this->current_price, 0, ',', '.') . ' ₺';
    }

    public function timeLeft(): string
    {
        if ($this->ends_at->isPast()) return 'Bitti';
        $diff = now()->diff($this->ends_at);
        if ($diff->days > 0)  return $diff->days . 'g';
        if ($diff->h   > 0)  return $diff->h   . 'sa';
        return $diff->i . 'dk';
    }

    public function isActive(): bool  { return $this->status === 'active' && $this->ends_at->isFuture(); }
    public function isEnding(): bool  { return $this->isActive() && $this->ends_at->diffInHours() < 24; }
    public function bidCount(): int   { return $this->bids()->count(); }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(300)
            ->format('webp')
            ->performOnCollections('images');

        $this->addMediaConversion('card')
            ->width(800)
            ->height(600)
            ->format('webp')
            ->performOnCollections('images');
    }
}
