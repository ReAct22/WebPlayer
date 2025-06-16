<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class PlaylistController extends Controller
{
    public function index(){
        $playlist = Video::all();
        return response()->json($playlist);
    }
}
