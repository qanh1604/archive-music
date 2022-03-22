<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\MarketSession\Models\MarketSession;
use Modules\MarketSession\Models\MarketSessionJoiner;

class MarketSessionDetail extends Model
{
    protected $table = "market_session_detail";
    protected $fillable = ['market_id','start_time','end_time','wheel_slot','gift'];

    public function marketSession()
    {
        return $this->belongsTo(MarketSession::class, 'market_id');
    }

    public function attended()
    {
        return $this->hasMany(MarketSessionJoiner::class, 'market_detail_id');
    }
}
