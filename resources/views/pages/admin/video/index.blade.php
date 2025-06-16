@extends('layouts.admin')
@section('title', 'Data Video')
@section('content')
    <div class="mb-2">
        <a href="{{ route('admin.video.create') }}" class="btn btn-sm btn-success">Add</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Video</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>thumbnail</th>
                        {{-- <th>Deskripsi</th> --}}
                        <th>Category</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($videos as $video)
                        <tr>
                            <td><img src="{{ asset('storage/' . $video->thumbnail) }}" alt="" width="130"
                                    height="129"></td>
                            {{-- <td>{{ $video->deskripsi }}</td> --}}
                            <td>{{ $video->category->nama }}</td>
                            <td>
                                <a href="{{ route('admin.video.edit', $video->id) }}"
                                    class="btn btn-sm btn-warning mb-2">Edit</a>
                                <form action="{{ route('admin.video.destroy', $video->id) }}" method="POST"
                                    onsubmit="return confirm('Apa anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center">Data Tidak Ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
