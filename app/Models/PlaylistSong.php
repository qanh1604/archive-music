<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class PlaylistSong extends Model
{
    public function playlist()
    {
        return $this->belongsTo(Playlist::class, 'playlist_id', 'id');
    }

    public function song()
    {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }
}
