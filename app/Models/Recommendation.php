<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Recommendation extends Model
{
    protected $fillable = ['song_id'];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
