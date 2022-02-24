<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use MarketSession;
use Modules\MarketSession\Models\MarketSessionSellerVideo;

class MarketSessionSeller extends Model
{
    protected $table = "market_session_seller";

    public function marketSession()
    {
        return $this->belongsTo(MarketSession::class);
    }

    public function sellerUser()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
