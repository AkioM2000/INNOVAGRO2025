@extends('layouts.app')

@section('title', 'Daftar Arsip')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Arsip</h3>
        <div class="card-tools">
            <a href="{{ route('archives.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Arsip
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($archives as $archive)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $archive->title }}</td>
                    <td>{{ $archive->category->name }}</td>
                    <td>{{ Str::limit($archive->description, 50) }}</td>
                    <td>{{ $archive->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('archives.show', $archive) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('archives.edit', $archive) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('archives.destroy', $archive) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus arsip ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada arsip</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
