<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\MarketSession\Models\MarketSession;

class MarketSessionDetail extends Model
{
    protected $table = "market_session_detail";

    public function marketSession()
    {
        return $this->belongsTo(MarketSession::class, 'market_id');
    }
}
