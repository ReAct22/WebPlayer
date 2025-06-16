@extends('layouts.admin')
@section('title', 'Data Category')
@section('content')
    <div class="mb-2">
        <a href="{{ route('admin.category.create') }}" class="btn btn-success btn-sm">Add Data</a>
    </div>
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
            <h3 class="card-title">Daftar Kategori</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->nama}}</td>
                            <td>
                                <a href="{{route('admin.category.edit', $category->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                {{-- <a href="#" class="btn btn-sm btn-danger">Hapus</a>4 --}}
                                <form action="{{route('admin.category.destroy', $category->id)}}" method="POST"
                                    onsubmit="return confirm('Apa anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center">Data Tidak Ada</td>
                    </tr>
                    @endforelse

                    <!-- Tambahkan baris data lainnya di sini -->
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
