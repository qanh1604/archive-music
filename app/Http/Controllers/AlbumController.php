<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use App\Models\Seller;
use App\Models\BusinessSetting;
use App\Models\Album;
use Auth;
use Hash;
use App\Notifications\EmailVerificationNotification;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $col_name = null;
        $query = null;
        $type = null;
        $sort_type = null;
        $sort_search = null;

        $albums = Album::query();

        if ($request->search != null){
            $albums = $albums
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        if($request->type){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $albums = $albums->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $albums = $albums->paginate(20);

        return view('backend.product.albums.index', [
            'albums' => $albums, 
            'sort_type' => $sort_type, 
            'col_name' => $col_name,
            'sort_type' => $sort_type,
            'sort_search' => $sort_search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check() && Auth::user()->user_type == 'admin'){
            // flash(translate('Admin can not be a seller'))->error();
            return view('backend.product.albums.create');
        }
        else{
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check() && Auth::user()->user_type == 'admin'){
            $request->validate([
                'name' => 'required',
                'image' => 'required',
            ]);

            $album = new Album;
            $album->artist_id = Auth::user()->id;
            $album->name = $request->name;
            $album->image = $request->image;
            $album->description = $request->description;
            $album->save();

            flash(translate('Album đã được thêm mới thành công!'))->success();
            return back();
        }
        else{
            return back();
        }
        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if(Auth::check() && Auth::user()->user_type == 'admin'){
            $album = Album::where('id', $request->id)->first();
            return view('backend.product.albums.edit', ['album' => $album]);
        }
        else{
            return back();
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAlbum(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
        ]);

        $album = Album::find($request->id);
        $album->name = $request->name;
        $album->image = $request->image;
        $album->description = $request->description;

        if($album->save()){
            flash(translate('Album đã được thêm mới thành công!'))->success();
            return back();
        }

        flash(translate('Đã có lỗi xảy ra. Cập nhập thất bại'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verify_form(Request $request)
    {
        if(Auth::user()->seller->verification_info == null){
            $shop = Auth::user()->shop;
            return view('frontend.user.seller.verify_form', compact('shop'));
        }
        else {
            flash(translate('Sorry! You have sent verification request already.'))->error();
            return back();
        }
    }

    public function verify_form_store(Request $request)
    {
        $data = array();
        $i = 0;
        foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
            $item = array();
            if ($element->type == 'text') {
                $item['type'] = 'text';
                $item['label'] = $element->label;
                $item['value'] = $request['element_'.$i];
            }
            elseif ($element->type == 'select' || $element->type == 'radio') {
                $item['type'] = 'select';
                $item['label'] = $element->label;
                $item['value'] = $request['element_'.$i];
            }
            elseif ($element->type == 'multi_select') {
                $item['type'] = 'multi_select';
                $item['label'] = $element->label;
                $item['value'] = json_encode($request['element_'.$i]);
            }
            elseif ($element->type == 'file') {
                $item['type'] = 'file';
                $item['label'] = $element->label;
                $item['value'] = $request['element_'.$i]->store('uploads/verification_form');
            }
            array_push($data, $item);
            $i++;
        }
        $seller = Auth::user()->seller;
        $seller->verification_info = json_encode($data);
        if($seller->save()){
            flash(translate('Your shop verification request has been submitted successfully!'))->success();
            return redirect()->route('dashboard');
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }
}
