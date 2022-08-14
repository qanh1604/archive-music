<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Recommendation;
use App\Models\Album;
use App\Models\Song;
use App\Models\Upload;
use App\Models\Artist;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Cache;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::where('status', 1)->latest()->paginate(20);

        return response()->json([
            'succes' => true,
            'data' => $artists
        ]);
    }

    public function detail(Request $request)
    {
        $artist = Artist::find($request->artist_id);

        $artist->total_songs = Song::where('artist_id', $artist->user->id)->count();
        $artist->total_albums = Album::where('artist_id', $artist->user->id)->count();

        return response()->json([
            'succes' => true,
            'data' => $artist
        ]);
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
