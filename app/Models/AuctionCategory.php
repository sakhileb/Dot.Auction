<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuctionCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class, 'category_id');
    }
}
