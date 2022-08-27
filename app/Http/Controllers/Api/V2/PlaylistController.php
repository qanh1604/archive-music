<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\ProductCollection;
use App\Http\Resources\V2\ProductMiniCollection;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Album;
use App\Models\Song;
use App\Models\Upload;
use App\Models\PlaylistSong;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Auth;
use Cache;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::where('user_id', Auth::user()->id)->latest()->get();

        foreach($playlists as &$playlist){
            $playlist_song = PlaylistSong::where('playlist_id', $playlist->id)->first();

            $playlists->total_song = PlaylistSong::where('playlist_id', $playlist->id)->count();
            $playlist->image = $playlist_song?$playlist_song->song->url->file_name:'';
        }

        return response()->json([
            'success' => true,
            'data' => $playlists
        ]);
    }

    public function create(Request $request){
        $data = $request->all();

        $playlist = new Playlist;
        $playlist->user_id = Auth::user()->id;
        $playlist->name = $data['name'];
        $playlist->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã tạo playlist thành công'
        ]);
    }

    public function delete(Request $request){
        $playlist = Playlist::find($request->playlist_id);

        if($playlist){
            $playlist->delete();
       
            return response()->json([
                'success' => true,
                'message' => 'Xóa playlist thành công'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy playlist'
            ]); 
        }
    }

    public function detail(Request $request){
        $playlist = Playlist::find($request->playlist_id);

        if($playlist){
            $playlist_songs = PlaylistSong::where('playlist_id', $playlist->id)->latest()->get();

            foreach($playlist_songs as &$item){
                $item->song_thumbnail = $item->song->url->file_name;
                $item->song_url = $item->song->song_url;
                $item->song_artist = $item->song->user->name;
            }
            
            return response()->json([
                'success' => true,
                'data' => $playlist_songs
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy playlist'
            ]); 
        }
    }

    public function add(Request $request){
        $data = $request->all();

        $playlist = Playlist::find($data['playlist_id']);

        if(isset($data['song_id'])){
            $checkSongExist = PlaylistSong::where('song_id', $data['song_id'])->exists();
            if($checkSongExist){
                return response()->json([
                    'success' => false,
                    'message' => 'Bài hát đã nằm trong playlist rồi'
                ]);
            }
        }
        
        $playlist_song = new PlaylistSong;

        if($playlist){
            $playlist_song->playlist_id = $data['playlist_id'];
            $playlist_song->song_id = $data['song_id'];
            $playlist_song->save();

            $playlist->total_songs++;
            $playlist->save();

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vô playlist thành công'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy playlist'
            ]);
        }
    }

    public function removeSong(Request $request){
        $playlist_song = PlaylistSong::find($request->id);
        $playlist = Playlist::where('id', $playlist_song->playlist_id)->first();

        if($playlist_song){
            $playlist_song->delete();

            $playlist->total_songs--;
            $playlist->save();
       
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy item'
            ]); 
        }
    }
}
