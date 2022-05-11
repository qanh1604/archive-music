<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \App\Models\Shop;
use \App\Models\Seller;
use MarketSession;

class MarketSessionJoiner extends Model
{
    protected $table = "market_session_joiner";

    public function marketSession()
    {
        return $this->belongsTo(MarketSession::class);
    }

    public function joinerUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'user_id', 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'user_id', 'user_id');
    }
}
