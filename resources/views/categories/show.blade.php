@extends('layouts.app')

@section('title', $category->name)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Category Details</h1>
        <div>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Category Information</h5>
                    <table class="table">
                        <tr>
                            <th style="width: 150px">Name</th>
                            <td>{{ $category->name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $category->description ?: 'No description provided' }}</td>
                        </tr>
                        <tr>
                            <th>Total Documents</th>
                            <td>{{ $category->documents_count }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $category->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $category->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Actions</h5>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this category?')">
                            <i class="fas fa-trash"></i> Delete Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Documents in this Category</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Uploaded By</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($category->documents as $document)
                                    <tr>
                                        <td>{{ $document->title }}</td>
                                        <td>{{ $document->user->name }}</td>
                                        <td>{{ $document->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No documents in this category</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
