<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\CategoryCollection;
use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\Song;
use App\Http\Resources\V2\ProductMiniCollection;
use Cache;

class CategoryController extends Controller
{

    public function index()
    {
        return new CategoryCollection(Category::paginate(15));
    }

    public function featured()
    {
        return Cache::remember('app.featured_categories', 86400, function(){
            return new CategoryCollection(Category::where('featured', 1)->get());
        });
    }

    public function home()
    {
        return Cache::remember('app.home_categories', 86400, function(){
            return new CategoryCollection(Category::whereIn('id', json_decode(get_setting('home_categories')))->get());
        });
    }

    public function top()
    {   
        return Cache::remember('app.top_categories', 86400, function(){
            return new CategoryCollection(Category::whereIn('id', json_decode(get_setting('home_categories')))->limit(20)->get());
        });
    }

    public function detail($id)
    {
        $songs = Song::where('category_id', $id)->get();
        return new ProductMiniCollection($songs);
    }
}
