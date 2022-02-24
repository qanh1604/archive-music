<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\User;

class MarketSession extends Model
{
    protected $table = "market_session";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
