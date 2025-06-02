@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit Kategori</h1>
        <a href="{{ route('categories.show', $category) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Details
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Kategori</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="afdeling_id">Afdeling</label>
                            <select name="afdeling_id" id="afdeling_id" class="form-control @error('afdeling_id') is-invalid @enderror" required>
                                <option value="">Pilih Afdeling</option>
                                @foreach($afdelings as $afdeling)
                                    <option value="{{ $afdeling->id }}" {{ old('afdeling_id', $category->afdeling_id) == $afdeling->id ? 'selected' : '' }}>
                                        {{ $afdeling->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('afdeling_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
