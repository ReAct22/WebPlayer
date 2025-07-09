@extends('layouts.admin')
@section('title', 'Tambah Data Barang')

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
            <h3 class="card-title">Tambah Data Barang</h3>
        </div>
        <div class="card-body">
            <form action="{{route('admin.barang.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama"
                                placeholder="Masukan Nama Category" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
