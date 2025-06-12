@extends('layouts.admin')
@section('title', 'Data Video')
@section('content')
    <div class="mb-2">
        <a href="{{route('admin.video.create')}}" class="btn btn-sm btn-success">Add</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Video</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Category</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($videos as $video)
                        <tr>
                            <td>{{ $video->judul }}</td>
                            <td>{{ $video->deskripsi }}</td>
                            <td>{{ $video->category->nama }}</td>
                            <td>
                                <a href="{{route('admin.video.edit', $video->id)}}" class="btn btn-sm btn-warning mb-2">Edit</a>
                                <button class="btn btn-sm btn-danger mb-2"></button>
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
