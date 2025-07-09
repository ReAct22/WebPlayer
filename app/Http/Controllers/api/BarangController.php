<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(){
        $barangs = Barang::all();
        return response()->json($barangs);
    }
}
