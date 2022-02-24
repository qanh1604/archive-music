<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
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
}
