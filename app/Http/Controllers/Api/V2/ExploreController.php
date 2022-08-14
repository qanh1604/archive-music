<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Recommendation;
use App\Models\Album;
use App\Http\Resources\V2\ProductMiniCollection;
use App\Models\Song;
use App\Models\Upload;
use App\Models\Artist;
use App\Models\Search;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Cache;

class ExploreController extends Controller
{
    public function chart()
    {
        $topSongs = Song::orderByRaw("CAST(view as UNSIGNED) DESC")->paginate(20);

        return new ProductMiniCollection($topSongs);
    }

    public function chartTop5()
    {
        $topSongs = Song::orderByRaw("CAST(view as UNSIGNED) DESC")->limit(5)->get();

        return new ProductMiniCollection($topSongs);
    }

    public function trending(Request $request)
    {
        $topSearches = Search::orderByRaw("CAST(count as UNSIGNED) DESC")->limit(3)->get()->pluck('query')->toArray();

        $trending = [];
        foreach($topSearches as $search){
            $song = Song::where(function ($query) use ($search) {
                foreach (explode(' ', trim($search)) as $word) {
                    $query->where('name', 'like', '%'.$word.'%')
                        ->orWhereHas('user', function($query) use ($word){
                            $query->where('name', 'like', '%'.$word.'%');
                        })->orWhereHas('album', function($query) use ($word){
                            $query->where('name', 'like', '%'.$word.'%');
                        })->orWhereHas('category', function($query) use ($word){
                            $query->where('name', 'like', '%'.$word.'%');
                        });
                }
            })->first();
            $trending[] = $song;
        }
        
        return new ProductMiniCollection($trending);
    }

    public function albums(Request $request)
    {
        $albums = Album::where('artist_id', $request->artist_id)->get();

        foreach($albums as &$album){
            $total_views = DB::table('songs')
                ->select(DB::raw('count(view) as view_count'))
                ->where('album_id', $album->id)
                ->get();
            $album->image = $album->image_url->file_name;
            $album->total_songs = Song::where('album_id', $album->id)->count();
            $album->total_views = $total_views[0]->view_count;
        }

        return response()->json([
            'succes' => true,
            'data' => $albums
        ]);
    }
}
