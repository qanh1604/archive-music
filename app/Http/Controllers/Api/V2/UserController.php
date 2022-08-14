<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\UserCollection;
use App\Models\User;
use App\Models\Artist;
use App\Models\Follower;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Auth;
class UserController extends Controller
{
    public function info($id)
    {
        return new UserCollection(User::where('id', $id)->get());
    }

    public function updateName(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'name' => $request->name
        ]);
        return response()->json([
            'message' => translate('Profile information has been updated successfully')
        ]);
    }

    public function getUserInfoByAccessToken(Request $request)
    {
        $false_response = [
            'result' => false,
            'id' => 0,
            'name' => "",
            'email' => "",
            'avatar' => "",
            'avatar_original' => "",
            'phone' => ""
        ];

        $token = PersonalAccessToken::findToken($request->access_token);
        if (!$token) {
            return response()->json($false_response);
        }
        
        $user = $token->tokenable;
        if ($user == null) {
            return response()->json($false_response);

        }

        return response()->json([
            'result' => true,
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'avatar_original' => api_asset($user->avatar_original),
            'phone' => $user->phone
        ]);
    }

    public function follow(Request $request)
    {
        $artist = Artist::findOrFail($request->artist_id);

        if(!$artist){
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy nghệ sĩ"
            ]);
        }

        $check = Follower::where('user_id', Auth::user()->id)->where('artist_id', $request->artist_id)->first();
        if($check){
            $check->delete();
            $artist->follower--;
            $artist->save();

            return response()->json([
                'success' => true,
                'message' => 'Hủy theo dõi thành công'
            ]);
        }

        $follower = new Follower;
        $follower->user_id = Auth::user()->id;
        $follower->artist_id = $request->artist_id;
        $follower->save();
        $artist->follower++;
        $artist->save();

        return response()->json([
            'success' => true,
            'message' => 'Theo dõi thành công'
        ]);
    }
}
