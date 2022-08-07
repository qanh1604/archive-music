<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Category;
use App\Models\Album;
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
                    'artist_id' => $data->user?$data->user->name:'',
                    'name' => $data->name,
                    'category' => $category?$category->name:'',
                    'icon' => $icon?$icon->file_name:'',
                    'image' => $image?$image:[],
                    'song_url' => $data->song_url,
                    'view' => $data->view,
                    'like' => $data->like,
                    'album' => $album?$album->name:'',
                    'lyric' => $data->lyric
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
