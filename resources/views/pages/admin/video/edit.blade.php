@extends('layouts.admin')

@section('title', 'Edit Data Video')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Data Video</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.video.update', $video->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        {{-- Judul --}}
                        <div class="mb-2">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $video->judul) }}"
                                class="form-control" placeholder="Masukkan Judul Video" required>
                            @error('judul')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-2">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $video->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="" class="form-label">Type Media</label>
                            <select name="type" id="type" class="form-control">
                                <option value="{{$video->type}}">{{ $video->type }}</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>

                        {{-- Upload Video --}}
                        <div class="mb-2">
                            <label for="video" class="form-label">Upload Video Baru (opsional)</label>
                            <input type="file" name="video" id="video" accept="video/*,image/png,image/jpg"
                                class="form-control">
                            @error('video')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Preview Video --}}
                        <div class="mb-2">
                            <label class="form-label">Preview Video Saat Ini</label><br>
                            <video width="320" height="240" controls>
                                <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                                Browser tidak mendukung pemutar video.
                            </video>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-2">
                            <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" placeholder="Masukkan Deskripsi">{{ old('deskripsi', $video->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
