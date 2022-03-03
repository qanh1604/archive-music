<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \Modules\MarketSession\Models\MarketSessionDetail;
use \Modules\MarketSession\Models\HotOrderDetail;

class HotOrder extends Model
{
    protected $table = "hot_orders";

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function marketDetail()
    {
        return $this->belongsTo(MarketSessionDetail::class, 'market_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(HotOrderDetail::class, 'order_id');
    }
}
