<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'auction_id', 'buyer_id', 'seller_id', 'winning_bid_id',
        'amount', 'commission_amount', 'status',
        'shipping_address', 'tracking_number',
        'paid_at', 'shipped_at', 'completed_at',
    ];

    protected $casts = [
        'paid_at'      => 'datetime',
        'shipped_at'   => 'datetime',
        'completed_at' => 'datetime',
        'amount'       => 'decimal:2',
    ];

    public function auction()  { return $this->belongsTo(Auction::class); }
    public function buyer()    { return $this->belongsTo(User::class, 'buyer_id'); }
    public function seller()   { return $this->belongsTo(User::class, 'seller_id'); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function winningBid(){ return $this->belongsTo(Bid::class, 'winning_bid_id'); }
}