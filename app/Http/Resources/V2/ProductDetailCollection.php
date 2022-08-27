<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Review;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Album;
use App\Models\Upload;

class ProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                $category = Category::where('id', $data->category_id)->first();
                $album = Album::where('id', $data->album_id)->first();
                $icon = Upload::where('id', $data->icon)->first();
                $imageList = explode(",",$data->image);
                $image = Upload::select('file_name')->whereIn('id', $imageList)->get();
                
                return [
                    'id' => $data->id,
                    'artist_id' => $data->artist_id,
                    'name' => $data->name,
                    'category' => $category?$category->name:'',
                    'icon' => $icon?$icon->file_name:'',
                    'image' => $image?$image:[],
                    'song_url' => $data->song_url,
                    'view' => $data->view,
                    'like' => $data->like,
                    'album' => $album?$album->name:'',
                    'lyric' => $data->lyric,
                    'artist' => $data->user->artist?$data->user->artist->name:$data->user->name
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

    protected function convertToChoiceOptions($data)
    {
        $result = array();
//        if($data) {
        foreach ($data as $key => $choice) {
            $item['name'] = $choice->attribute_id;
            $item['title'] = Attribute::find($choice->attribute_id)->getTranslation('name');
            $item['options'] = $choice->values;
            array_push($result, $item);
        }
//        }
        return $result;
    }

    protected function convertPhotos($data)
    {
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
