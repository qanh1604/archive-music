<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Song extends Model
{
    protected $fillable = [
        'name', 'artist_id', 'song_url', 'lyric', 'category_id', 'theme_id', 'view', 'like',
        'is_publish', 'icon', 'image', 'album_id'
    ];

    // public function getTranslation($field = '', $lang = false)
    // {
    //     $lang = $lang == false ? App::getLocale() : $lang;
    //     $product_translations = $this->product_translations->where('lang', $lang)->first();
    //     return $product_translations != null ? $product_translations->$field : $this->$field;
    // }

    // public function product_translations()
    // {
    //     return $this->hasMany(ProductTranslation::class);
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function brand()
    // {
    //     return $this->belongsTo(Brand::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'artist_id', 'id');
    }

    // public function orderDetails()
    // {
    //     return $this->hasMany(OrderDetail::class);
    // }

    // public function reviews()
    // {
    //     return $this->hasMany(Review::class)->where('status', 1);
    // }

    // public function wishlists()
    // {
    //     return $this->hasMany(Wishlist::class);
    // }

    // public function stocks()
    // {
    //     return $this->hasMany(ProductStock::class);
    // }

    // public function taxes()
    // {
    //     return $this->hasMany(ProductTax::class);
    // }

    // public function flash_deal_product()
    // {
    //     return $this->hasOne(FlashDealProduct::class);
    // }

    // public function bids()
    // {
    //     return $this->hasMany(AuctionProductBid::class);
    // }

    // public function scopePhysical($query)
    // {
    //     return $query->where('digital', 0);
    // }

    // public function thumbnailImage()
    // {
    //     return $this->belongsTo(Upload::class, 'thumbnail_img');
    // }
}
