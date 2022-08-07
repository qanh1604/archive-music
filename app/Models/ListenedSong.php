<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListenedSong extends Model
{
    use SoftDeletes;
    
    public function songs() {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
