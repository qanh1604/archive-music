<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Models\User;
use Cache;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $user_seller = User::where('user_type', 'seller')->paginate(15);
        return response()->json($user_seller);
    }

}
