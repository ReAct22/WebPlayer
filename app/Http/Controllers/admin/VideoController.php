<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::all();
        return view('pages.admin.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.video.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'video' => 'required|file|mimes:png,jpg,mp4,mov,avi,mkv|max:204800',
            'type' => 'required'
        ]);

        try {
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $videoPath = $file->storeAs('videos', $fileName, 'public');
            }

            Video::create([
                'category_id' => $request->category_id,
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'deskripsi' => $request->deskripsi ?? null,
                'video' => $videoPath ?? null,
                'user_id' => 0,
                'type' => $request->type
            ]);

            return redirect()->route('admin.video.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
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
        $video = Video::findOrFail($id);
        $categories = Category::all();
        return view('pages.admin.video.edit', compact('video', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'video' => 'nullable|file|mimes:png,jpg,mp4,mov,avi,mkv|max:204800', // video optional
            'type' => 'required'
        ]);

        $video = Video::findOrFail($id);

        try {
            // Cek apakah ada file video baru yang diupload
            if ($request->hasFile('video')) {
                // Hapus file lama jika masih ada
                if ($video->video && Storage::disk('public')->exists($video->video)) {
                    Storage::disk('public')->delete($video->video);
                }

                // Simpan file video yang baru
                $file = $request->file('video');
                $videoPath = $file->store('videos', 'public');
            } else {
                // Tetap pakai path lama
                $videoPath = $video->video;
            }

            // Update data video
            $video->update([
                'category_id' => $request->category_id,
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'deskripsi' => $request->deskripsi ?? '',
                'video' => $videoPath,
                'user_id' =>  0, // fallback 0 kalau belum login
                'type' => $request->type
            ]);

            return redirect()->route('admin.video.index')->with('success', 'Video berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari video berdasarkan ID
        $video = Video::findOrFail($id);

        // Hapus file video dari storage jika ada
        if ($video->video && Storage::disk('public')->exists($video->video)) {
            Storage::disk('public')->delete($video->video);
        }

        // Hapus data dari database (soft delete)
        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Video berhasil dihapus.');
    }
}
