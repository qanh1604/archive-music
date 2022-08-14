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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'artist_id', 'id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }

    public function url()
    {
        return $this->belongsTo(Upload::class, 'icon', 'id');
    }
}
