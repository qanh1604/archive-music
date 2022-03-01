<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \Modules\MarketSession\Models\MarketSessionDetail;

class MarketSession extends Model
{
    protected $table = "market_session";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function marketDetail()
    {
        return $this->hasMany(MarketSessionDetail::class, 'market_id');
    }
}
