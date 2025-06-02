@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Message -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-white p-3 shadow-sm me-3">
                            <i class="fas fa-user text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Selamat Datang, {{ Auth::user()->name }}</h4>
                            <p class="text-muted mb-0">
                                @if(Auth::user()->roles->isNotEmpty())
                                <span class="badge bg-primary">{{ Auth::user()->roles->first()->name }}</span>
                                @endif
                                | {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Total Documents Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-0 text-uppercase fw-semibold">Total Dokumen</h6>
                            <span class="h3 fw-bold mb-0">{{ $totalDocuments }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded">
                                <i class="fas fa-file-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-0 text-uppercase fw-semibold">Total Kategori</h6>
                            <span class="h3 fw-bold mb-0">{{ $totalCategories }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="bg-success bg-opacity-10 text-success p-3 rounded">
                                <i class="fas fa-folder fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-0 text-uppercase fw-semibold">Total Pengguna</h6>
                            <span class="h3 fw-bold mb-0">{{ $totalUsers }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="bg-info bg-opacity-10 text-info p-3 rounded">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Documents Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-0 text-uppercase fw-semibold">Dokumen Terbaru</h6>
                            <span class="h3 fw-bold mb-0">{{ $recentDocuments }}</span>
                            <div class="text-muted small">7 Hari Terakhir</div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Latest Documents -->
        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Dokumen Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestDocuments as $document)
                                <tr>
                                    <td>{{ $document->title }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $document->category->name }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents by Category -->
        <div class="col-12 col-xl-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Dokumen per Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kategori</th>
                                    <th class="text-end">Total Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentsByCategory as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td class="text-end">
                                        <span
                                            class="badge rounded-pill bg-{{ $category->documents_count > 0 ? 'info' : 'secondary' }}">
                                            {{ $category->documents_count }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.table> :not(caption)>*>* {
    padding: 1rem;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}

.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}
</style>
@endsection