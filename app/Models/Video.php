<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\MarketSession\Models\MarketSession;

class Video extends Model
{
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'market_id', 'seller_id', 'name', 'url', 'file_id', 'type'
    ];

    public function market()
    {
    	return $this->belongsTo(MarketSession::class);
    }
}
