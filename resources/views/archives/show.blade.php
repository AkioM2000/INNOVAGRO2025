@extends('layouts.app')

@section('title', 'Detail Arsip')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Arsip</h3>
        <div class="card-tools">
            <a href="{{ route('archives.edit', $archive) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('archives.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px">Judul</th>
                <td>{{ $archive->title }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $archive->category->name }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $archive->description }}</td>
            </tr>
            <tr>
                <th>File</th>
                <td>
                    <a href="{{ asset('storage/' . $archive->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-download"></i> Download
                    </a>
                </td>
            </tr>
            <tr>
                <th>Tanggal Dibuat</th>
                <td>{{ $archive->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <th>Terakhir Diperbarui</th>
                <td>{{ $archive->updated_at->format('d-m-Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
