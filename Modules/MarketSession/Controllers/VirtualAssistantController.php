<?php

namespace Modules\MarketSession\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VirtualAssistant;
use App\Models\Seller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp;

class VirtualAssistantController extends Controller
{
    public function index(Request $request)
    {
        $seller = "";
        
        $virtual_assistants = VirtualAssistant::with('seller')->paginate(15);

        return view('MarketSession::VirtualAssistant.index', compact('virtual_assistants'));
    }

    public function create(Request $request)
    {
        return view('MarketSession::VirtualAssistant.create');
    }

    public function save(Request $request)
    {
        $virtual_assistant = new VirtualAssistant;
        $virtual_assistant->video = $request->video;
        $virtual_assistant->save();

        flash(translate('Trợ lý ảo đã lưu thành công'))->success();

        return back();
    }

    public function edit(Request $request)
    {
        $information = CharterInformation::where('id', $request->id)->first();

        return view('MarketSession::CharterInformation.edit', compact('information'));
    }

    public function saveEdit(Request $request)
    {
        $virtual_assistant = VirtualAssistant::where('id', $request->id)->first();
        $virtual_assistant->video = $request->video;
        $virtual_assistant->save();

        return response()->json($virtual_assistant);
    }

    public function delete(Request $request)
    {
        $virtual_assistant = VirtualAssistant::where('id', $request->id)->first();
        $virtual_assistant->delete();
        flash(translate('Xóa thành công'))->success();

        return back();
    }
}