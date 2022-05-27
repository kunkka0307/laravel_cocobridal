<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @var ProfileService
     */    
    protected $service;

    public function __construct(
        ProfileService $service
    )
    {
        $this->service = $service;
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        return tap($user)->update($request->only('name', 'email'));
    }

    public function profileMainUpdate(Request $request)
    {
        $profile = $this->service->updateMain($request->all());
        return response()->json(['profile' => $profile]);
    }
    
    public function profileCommentUpdate(Request $request)
    {
        auth('api')->user()->profile->update(['comment' => $request->comment]);

        return response()->json(['profile' => auth('api')->user()->profile]);
    }
    
    public function profileDataUpdate(Request $request)
    {
        auth('api')->user()->profile->update($request->except(['_token']));

        return response()->json(['profile' => auth('api')->user()->profile]);
    }

    public function getMasterData()
    {
        return response()->json(['data' => config('values')]);
    }

    public function getRooms()
    {
        return response()->json(['data' => \App\Models\Room::all()]);
    }
}
