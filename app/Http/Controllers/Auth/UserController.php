<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ImageUpload;

class UserController extends Controller
{
    use ImageUpload;

    /**
     * Get authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function current(Request $request)
    {
        $user = \App\Models\User::where('id', $request->user()->id)
                        ->with('profile')
                        ->with('books')
                        ->with('favorites')
                        ->with('searches')
                        ->first();
        return response()->json($user);
    }

    public function uploadAvatar(Request $request)
    {
        \DB::beginTransaction();

        try {
            $avatar = $request->file('avatar');
            if (isset($avatar)) {
                $user = auth('api')->user();
                $url = $this->imageUpdateWithThumb("users/{$user->id}", $avatar, 300);

                $user->profile->update(['avatar' => $url]);
            }

            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();

            return response()->json(['status' => 'failed']);
        }

        return response()->json(['status' => 'success', 'url' => auth('api')->user()->profile->avatar_url]);
    }
}
