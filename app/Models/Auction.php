<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Auction extends Model
{
    protected $fillable = [
        'seller_id', 'category_id', 'title', 'description', 'image_path',
        'starting_price', 'reserve_price', 'current_price', 'buy_now_price',
        'bid_increment', 'status', 'starts_at', 'ends_at',
    ];

    protected $casts = [
        'starts_at'      => 'datetime',
        'ends_at'        => 'datetime',
        'starting_price' => 'decimal:2',
        'current_price'  => 'decimal:2',
        'reserve_price'  => 'decimal:2',
        'buy_now_price'  => 'decimal:2',
        'bid_increment'  => 'decimal:2',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AuctionCategory::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class)->latest();
    }

    public function winningBid(): HasOne
    {
        return $this->hasOne(Bid::class)->where('is_winning', true);
    }

    public function isActive(): bool
    {
        return $this->status === 'active'
            && now()->between($this->starts_at, $this->ends_at);
    }

    public function minimumBid(): float
    {
        return (float) $this->current_price + (float) $this->bid_increment;
    }
}
