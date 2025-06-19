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
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,mov,avi,mkv,png,jpg,jpeg|max:204800',
            'type' => 'required',
            'thumbnail' => 'nullable|mimes:png,jpg'
        ]);

        try {
            $videoPath = '';
            $thumbPath = '';
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $inputPath = $file->getPathname();

                // File output compression
                $compressedFileName = time() . '_compressed.mp4';
                $compressedPath = storage_path('app/public/videos/' . $compressedFileName);

                // Compress video using ffmpeg
                $ffmpeg = "/usr/bin/ffmpeg";
                $cmd = "$ffmpeg -i $inputPath -vcodec libx264 -crf 23 -acodec aac -strict -2 $compressedPath";

                exec($cmd, $output, $return_var);

                if ($return_var == 0) {
                    // Compress sukses
                    $videoPath = 'videos/' . $compressedFileName;
                } else {
                    // Compress gagal, fallback ke video asli
                    $fileName = time() . "_" . $file->getClientOriginalName();
                    $videoPath = $file->storeAs('videos', $fileName, 'public');
                }
            }

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filethumb = time() . '-' . $file->getClientOriginalName();
                $thumbPath = $file->storeAs('thumb', $filethumb, 'public');
            }

            Video::create([
                'category_id' => $request->category_id,
                'judul'      => $request->judul ?? 'null',
                'slug'       => Str::slug($request->judul),
                'deskripsi'  => $request->deskripsi ?? 'null',
                'video'      => $videoPath ?? 'null',
                'user_id'    => 0,
                'type'       => $request->type,
                'thumbnail'  => $thumbPath ?? '',
            ]);

            return redirect()
                ->route('admin.video.index')
                ->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
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
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,mov,avi,mkv,png,jpg,jpeg|max:204800',
            'type' => 'required',
            'thumbnail' => 'nullable|mimes:png,jpg'
        ]);

        $video = Video::findOrFail($id);

        try {
            $videoPath = $video->video;
            $thumbPath = $video->thumbnail;

            // Cek dan proses video baru jika ada
            if ($request->hasFile('video')) {
                // Hapus file lama
                if ($video->video && Storage::disk('public')->exists($video->video)) {
                    Storage::disk('public')->delete($video->video);
                }

                $file = $request->file('video');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $inputPath = $file->getPathname();

                $compressedFileName = time() . '_compressed.mp4';
                $compressedPath = storage_path('app/public/videos/' . $compressedFileName);

                $ffmpeg = "/usr/bin/ffmpeg";
                $cmd = "$ffmpeg -i $inputPath -vcodec libx264 -crf 23 -acodec aac -strict -2 $compressedPath";

                exec($cmd, $output, $return_var);

                if ($return_var == 0) {
                    $videoPath = 'videos/' . $compressedFileName;
                } else {
                    // fallback jika gagal kompres
                    $videoPath = $file->storeAs('videos', $fileName, 'public');
                }
            }

            // Cek dan proses thumbnail jika ada
            if ($request->hasFile('thumbnail')) {
                if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                    Storage::disk('public')->delete($video->thumbnail);
                }

                $file = $request->file('thumbnail');
                $filethumb = time() . '-' . $file->getClientOriginalName();
                $thumbPath = $file->storeAs('thumb', $filethumb, 'public');
            }

            // Update ke database
            $video->update([
                'category_id' => $request->category_id,
                'judul' => $request->judul ?? 'null',
                'slug' => Str::slug($request->judul),
                'deskripsi' => $request->deskripsi ?? 'null',
                'video' => $videoPath,
                'user_id' => 0,
                'type' => $request->type,
                'thumbnail' => $thumbPath ?? 'null',
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

        if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        // Hapus data dari database (soft delete)
        $video->delete();

        return redirect()->route('admin.video.index')->with('success', 'Video berhasil dihapus.');
    }
}
