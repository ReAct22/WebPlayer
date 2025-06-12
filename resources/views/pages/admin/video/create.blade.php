@extends('layouts.admin')

@section('title', 'Tambah Data Video')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Data Video</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.video.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                                class="form-control" placeholder="Masukan Judul Video" required>
                            @error('judul')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                <option value="">Pilih Type Media</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="video" class="form-label">Upload Video</label>
                            <input type="file" name="video" id="video" accept="video/*,image/png,image/jpg"
                                class="form-control">
                            @error('video')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" placeholder="Masukan Deskripsi">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button class="btn btn-sm btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
