<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Category;
use App\Models\Album;
use App\Models\Favourite;
use App\Models\Upload;

class ProductMiniCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $category = Category::where('id', $data->category_id)->first();
                $album = Album::where('id', $data->album_id)->first();
                $icon = Upload::where('id', $data->icon)->first();
                $imageList = explode(",",$data->image);
                $image = Upload::select('file_name')->whereIn('id', $imageList)->get();
                
                return [
                    'id' => $data->id,
                    'artist' => $data->user?$data->user->artist->name:$data->user->name,
                    'name' => $data->name,
                    'category' => $category?$category->name:'',
                    'icon' => $icon?$icon->file_name:'',
                    'image' => $image?$image:[],
                    'song_url' => $data->song_url,
                    'view' => $data->view,
                    'like' => $data->like,
                    'album_name' => $album?$album->name:'',
                    'is_like' => Favourite::where('user_id', Auth::user()->id)->where('song_id', $data->id)->exists() ? 1 : 0
                    // 'lyric' => $data->lyric
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
