<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('pages.admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        return view('pages.admin.category.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'=> "required|string|max:255",
            'barang_id' => 'required'
        ]);
        try {
            Category::create($request->all());

            return redirect()->route('admin.category.index')->with('success', "Data Berhasil disimpan");
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', "Terjadi kesalahan: ".$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $barangs = Barang::all();
        return view('pages.admin.category.edit', compact('category','barangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'barang_id' => 'required'
        ]);

        $category = Category::findOrFail($id);

        try {
            $category->update($request->all());
            return redirect()->route('admin.category.index')->with('success', 'Data Berhasil Diupdate');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', "Terjadi kesalahan: ".$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->route('admin.category.index')->with('success', "Data Berhasil Dihapus");
        } catch (\Throwable $th) {
            return redirect()->route('admin.category.index')->with('error', 'Gagal menghapus data: ' . $th->getMessage());
        }
    }
}
