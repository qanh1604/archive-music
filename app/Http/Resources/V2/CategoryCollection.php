<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Utility\CategoryUtility;
use App\Models\Upload;

class CategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $icon = Upload::where('id', $data->icon)->first();
                $banner = Upload::where('id', $data->banner)->first();
                return [
                    'id' => $data->id,
                    'name' => $data->getTranslation('name'),
                    'banner' => $banner?$banner->file_name:'',
                    'icon' => $icon?$icon->file_name:''
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
