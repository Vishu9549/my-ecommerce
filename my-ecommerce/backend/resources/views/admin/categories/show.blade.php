@extends('layouts.admin')


@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">📂 Category Details</h4>
            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary">← Back to Categories</a>
        </div>

        <div class="row">

            <div class="col-lg-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $category->name }}</p>

                        <p><strong>Slug:</strong> {{ $category->slug }}</p>
                        <p><strong>Parent Category:</strong> {{ $category->parent?->name ?? 'None' }}</p>
                        <p><strong>Status:</strong>
                            <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </p>
                        <p><strong>Show in Menu:</strong>
                            <span class="badge {{ $category->show_in_menu ? 'bg-info' : 'bg-secondary' }}">
                                {{ $category->show_in_menu ? 'Yes' : 'No' }}
                            </span>
                        </p>
                        <p><strong>Short Description:</strong> {{ $category->short_description ?? '-' }}</p>
                        <p><strong>URL Key:</strong> {{ $category->url_key }}</p>
                        <p><strong>Related Products:</strong>
                            @if($category->products->isNotEmpty())
                                {{ $category->products->pluck('name')->implode(', ') }}
                            @else
                                <em>No related products assigned.</em>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">SEO & Description</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Meta Title:</strong> {{ $category->meta_title ?? '-' }}</p>
                        <p><strong>Meta Tag:</strong> {{ $category->meta_tag ?? '-' }}</p>
                        <p><strong>Meta Description:</strong> {{ $category->meta_description ?? '-' }}</p>
                        <p><strong>Full Description:</strong></p>
                        <div class="border p-2 rounded bg-light">
                            {!! nl2br(e($category->description ?? 'N/A')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($category->image)
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">Category Image</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset('storage/categories/' . $category->image) }}" alt="Category Image"
                                class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection