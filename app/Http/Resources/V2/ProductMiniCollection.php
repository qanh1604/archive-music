<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Category;

class ProductMiniCollection extends ResourceCollection
{
    public function toArray($request)
    {
       
        return [
            'data' => $this->collection->map(function($data) {
                $category = Category::where('id', $data->category_id)->first();
                return [
                    'id' => $data->id,
                    'name' => $data->getTranslation('name'),
                    'category' => $category->name,
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    'has_discount' => home_base_price($data, false) != home_discounted_base_price($data, false) ,
                    'stroked_price' => home_base_price($data),
                    'main_price' => home_discounted_base_price($data),
                    'rating' => (double) $data->rating,
                    'sales' => (integer) $data->num_of_sale,
                    'links' => [
                        'details' => route('products.show', $data->id),
                    ]
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
