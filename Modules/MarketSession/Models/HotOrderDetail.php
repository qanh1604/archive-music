<?php

namespace Modules\MarketSession\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\Product;
use \Modules\MarketSession\Models\HotOrder;

class HotOrderDetail extends Model
{
    protected $table = "hot_order_detail";

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function orders()
    {
        return $this->belongsTo(HotOrder::class, 'order_id');
    }
}
