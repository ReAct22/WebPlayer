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
            <form id="formSubmit" action="{{ route('admin.video.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                                class="form-control" placeholder="Masukan Judul Video">
                            @error('judul')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="" class="form-label">Nama Narasumber</label>
                            <input type="text" name="nama" placeholder="Masukan Nama Narassumber" id="" class="form-control">
                            @error('nama')
                                <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="" class="form-label">Umur Narasumber</label>
                            <input type="text" name="umur" id="" class="form-control" placeholder="Masukan Umur">
                            @error('umur')
                                <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="" class="form-label">Perkerjaan Narasumber</label>
                            <input type="text" name="perkerjaan" id="" class="form-control" placeholder="Masukan Perkerjaan ">
                            @error('perkerjaan')
                                <div class="text-danger">{{$message}}</div>
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
                            <label for="">Type Media</label>
                            <select name="type" id="type" class="form-control">
                                <option value="">Pilih Type Media</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                             @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="mb-2">
                            <label for="video" class="form-label">Upload Media</label>
                            <input type="file" name="video" id="file" accept="*" class="form-control" class="form-control">
                            @error('video')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="" class="form-label">Thumbnail (Opsional)</label>
                            <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                            @error('thumbnail')
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

                <button id="submitBtn" class="btn btn-sm btn-success">Simpan</button>
                <span id="loadingSpinner" class="spinner-border text-info ml-2 d-none" role="status">
                    <span class="sr-only">Memproses...</span>
                </span>

                <div class="progress mt-2 d-none" id="loadingProgressBar">
                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                        aria-valuemax="100">0%</div>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('formSubmit').addEventListener('submit', function(e) {
            // Tampilkan spinner
            document.getElementById('loadingSpinner').classList.remove('d-none');
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = "Menyimpan...";

            // Tampilkan progress bar
            var progress = 0;
            var progressBar = document.getElementById('loadingProgressBar');
            progressBar.classList.remove('d-none');
            progressBar.style.width = progress + '%';
            progressBar.innerHTML = progress + '%';

            // Simulasi proses (karena upload sebenernya terjadi di server)
            var interval = setInterval(function() {
                if (progress < 100) {
                    progress++;
                    progressBar.style.width = progress + '%';
                    progressBar.innerHTML = progress + '%';
                } else {
                    clearInterval(interval);
                    // Setelah 100% boleh diberhentikan
                }
            }, 50);
        });
    </script>
@endpush
