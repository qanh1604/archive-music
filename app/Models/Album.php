<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;
    
    public function songs() {
        return $this->hasMany(Song::class, 'album_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'artist_id', 'id');
    }

    public function image_url()
    {
        return $this->belongsTo(Upload::class, 'image', 'id');
    }
}
