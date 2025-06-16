<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategorisController extends Controller
{
    public function index(){
        $categoris = Category::all();
        return response()->json($categoris);
    }
}
