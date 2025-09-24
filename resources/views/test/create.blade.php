@extends('adminlte::page')

@section('title', 'Test Admin')

@section('content_header')
    <h1><i class="fas fa-flask"></i> Test Panel Admin</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <form action="{{ route('test.admin.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <p>Ini adalah form uji coba. Jika tombol "Simpan" berhasil redirect ke halaman index dengan pesan sukses → artinya sistem routing & form submit LARAVEL ANDA MASIH SEHAT.</p>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Simpan Data (Test)</button>
                <a href="{{ route('portal.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@stop