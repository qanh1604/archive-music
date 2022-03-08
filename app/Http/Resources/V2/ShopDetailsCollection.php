<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use \App\Models\Product;

class ShopDetailsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $tmpData = [
                    'id' => $data->id,
                    'user_id' => intval($data->user_id) ,
                    'name' => $data->name,
                    'logo' => api_asset($data->logo),
                    'sliders' => get_images_path($data->sliders),
                    'address' => $data->address,
                    'facebook' => $data->facebook,
                    'google' => $data->google,
                    'twitter' => $data->twitter,
                    'true_rating' => (double) $data->user->seller->rating,
                    'rating' => (double) $data->user->seller->rating,
                    'meta_description' => $data->meta_description,
                    'background_img' => $data->background_img,
                    'virtual_assistant' => $data->virtual_assistant,
                ];

                $products = Product::with('category')->where('user_id', intval($data->user_id))->get();
                $productCategory = [];
                $productCategoryId = [];
        
                foreach($products as $product){
                    if($product->category){
                        if(!in_array($product->category->id, $productCategoryId)){
                            $productCategory[] = $product->category->name;
                            $productCategoryId[] = $product->category->id;
                        }
                    }
                }
        
                $tmpData['category'] = implode(', ', $productCategory);
                return $tmpData;
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

    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
