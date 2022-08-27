<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Album;
use App\Models\Song;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Cache;

class AlbumController extends Controller
{
    public function newest()
    {
        $albums = Album::latest()->paginate(20);
        
        foreach($albums as &$album){
            $album->image = $album->image_url->file_name;
            $album->artist = $album->user->artist ? $album->user->artist->name : $album->user->name;
        }

        return response()->json($albums);
    }

    public function detail($id){
        $album = Album::find($id);
        
        if($album){
            $album->artist = $album->user->artist?$album->user->artist->name:$album->user->name;
            $album->image = $album->image_url->file_name;
            $album->total_songs = Song::where('album_id', $album->id)->count();
            $total_views = DB::table('songs')
                ->select(DB::raw('count(view) as view_count'))
                ->where('album_id', $album->id)
                ->get();
            $album->total_views = $total_views[0]->view_count;
        }
        
        return response()->json($album);
    }
}
