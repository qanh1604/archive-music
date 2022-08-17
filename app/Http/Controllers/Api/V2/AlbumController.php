<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\ProductCollection;
use App\Http\Resources\V2\ProductMiniCollection;
use App\Http\Resources\V2\ProductDetailCollection;
use App\Http\Resources\V2\FlashDealCollection;
use App\Models\FlashDeal;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Recommendation;
use App\Models\Color;
use App\Models\Album;
use App\Models\Song;
use App\Models\Upload;
use App\Models\ListenedSong;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;
use App\Utility\SearchUtility;
use Stripe\Exception\CardException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Auth;
use Cache;

class AlbumController extends Controller
{
    public function newest()
    {
        $albums = Album::latest()->limit(5)->get();
        
        foreach($albums as &$album){
            $album->image = $album->image_url->file_name;
        }

        return response()->json([
            'success' => true,
            'data' => $albums
        ]);
    }

    
}
