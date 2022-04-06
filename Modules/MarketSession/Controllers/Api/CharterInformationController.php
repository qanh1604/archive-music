<?php

namespace Modules\MarketSession\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\MarketSession\Models\CharterInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp;

class CharterInformationController extends Controller
{
    public function index(Request $request)
    {
        $information = CharterInformation::latest()->get();

        return response()->json($information);

    }
}