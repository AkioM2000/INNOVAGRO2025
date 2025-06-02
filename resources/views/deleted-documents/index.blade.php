@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Dokumen yang Telah Dihapus</h2>
                </div>

                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form action="{{ route('deleted-documents.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Cari judul, deskripsi, atau nomor file..."
                                        value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="date_from" placeholder="Tanggal Dari"
                                    value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="date_to" placeholder="Tanggal Sampai"
                                    value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul Dokumen</th>
                                    <th>Nomor File</th>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                                    <th>Diminta Oleh</th>
                                    @endif
                                    <th>Alasan Penghapusan</th>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                                    <th>Diproses Oleh</th>
                                    @endif
                                    <th>Tanggal Penghapusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedDocuments as $request)
                                <tr>
                                    <td>
                                        @if($request->document)
                                        {{ $request->document->title }}
                                        @else
                                        <span class="text-muted">Dokumen telah dihapus</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->document)
                                        {{ $request->document->file_number }}
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                                    <td>{{ $request->requester->name }}</td>
                                    @endif
                                    <td>{{ $request->reason }}</td>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                                    <td>{{ $request->processor->name }}</td>
                                    @endif
                                    <td>{{ $request->processed_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager') ? '6' : '4' }}"
                                        class="text-center">Tidak ada dokumen yang telah dihapus</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $deletedDocuments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
