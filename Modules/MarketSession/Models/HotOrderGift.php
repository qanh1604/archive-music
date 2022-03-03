<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \Modules\MarketSession\Models\MarketSessionDetail;
use \Modules\MarketSession\Models\HotOrderDetail;

class HotOrderGift extends Model
{
    protected $table = "hot_order_gift";
}
