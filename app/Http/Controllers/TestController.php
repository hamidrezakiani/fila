<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserActivityResource;
use App\Models\Post;
use App\Models\UserActivity;

class TestController extends Controller
{
    public function index()
    {
           Post::create([
               'title' => 'test',
               'text' => 'how to implement user log activity'
           ]);
    }

    public function getUserActivity($user_id)
    {
        return response()->json(UserActivityResource::collection(UserActivity::where('user_id',auth('api')->id())->get()));
    }
}
