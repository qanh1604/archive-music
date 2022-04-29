<?php

namespace Modules\MarketSession\Controllers;

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

        return view('MarketSession::CharterInformation.index', compact('information'));
    }

    public function create(Request $request)
    {
        return view('MarketSession::CharterInformation.create');
    }

    public function save(Request $request)
    {
        $information = new CharterInformation;
        $information->title = $request->title;
        $information->content = $request->content;
        $information->image = $request->image;
        $information->save();

        flash(translate('Thông tin điều lệ đã lưu thành công'))->success();

        return back();
    }

    public function edit(Request $request)
    {
        $information = CharterInformation::where('id', $request->id)->first();

        return view('MarketSession::CharterInformation.edit', compact('information'));
    }

    public function saveEdit(Request $request)
    {
        DB::table('charter_information')
        ->where('id', $request->id)
        ->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
        ]);

        flash(translate('Thông tin điều lệ đã được cập nhập thành công'))->success();

        return back();
    }

    public function delete(Request $request)
    {
        DB::table('charter_information')
        ->where('id', $request->id)
        ->delete();
        flash(translate('Thông tin điều lệ đã xóa cập nhập thành công'))->success();

        return back();
    }
}