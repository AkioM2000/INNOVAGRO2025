@extends('layouts.app')

@section('content')
<div class="main-container container-fluid">
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="">Total Documents</h6>
                            <h3 class="mb-2 number-font">{{ $totalDocuments }}</h3>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-primary-gradient box-shadow-primary">
                                <i class="fe fe-file-text text-white fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="">Total Categories</h6>
                            <h3 class="mb-2 number-font">{{ $totalCategories }}</h3>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-secondary-gradient box-shadow-secondary">
                                <i class="fe fe-folder text-white fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="">Total Users</h6>
                            <h3 class="mb-2 number-font">{{ $totalUsers }}</h3>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-success-gradient box-shadow-success">
                                <i class="fe fe-users text-white fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="">Recent Documents</h6>
                            <h3 class="mb-2 number-font">{{ $recentDocuments }}</h3>
                            <p class="text-muted mb-0">Last 7 Days</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-danger-gradient box-shadow-danger">
                                <i class="fe fe-clock text-white fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-1 END -->

    <!-- ROW-2 -->
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Documents</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">Title</th>
                                    <th class="wd-25p border-bottom-0">Category</th>
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
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Documents by Category</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">Category</th>
                                    <th class="wd-25p border-bottom-0">Total Documents</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentsByCategory as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $category->documents_count }}</span>
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
    <!-- ROW-2 END -->
</div>
@endsection
