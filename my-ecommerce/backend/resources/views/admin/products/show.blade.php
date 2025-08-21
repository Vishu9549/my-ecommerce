@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0">Product Details</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6"><strong>Name:</strong> {{ $product->name }}</div>
                <div class="col-md-6">
                    <strong>Status:</strong>
                    <span class="badge badge-{{ $product->status ? 'success' : 'secondary' }}">
                        {{ $product->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4"><strong>Is Featured:</strong> {{ $product->is_featured ? 'Yes' : 'No' }}</div>
                <div class="col-md-4"><strong>SKU:</strong> {{ $product->sku }}</div>
                <div class="col-md-4"><strong>Qty:</strong> {{ $product->qty }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Stock Status:</strong> {{ ucfirst($product->stock_status) }}</div>
                <div class="col-md-6"><strong>Weight:</strong> {{ $product->weight }} kg</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6"><strong>Price:</strong> ₹{{ $product->price }}</div>
                <div class="col-md-6"><strong>Special Price:</strong> ₹{{ $product->special_price ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6"><strong>Special Price From:</strong> {{ $product->special_price_from ?? '-' }}</div>
                <div class="col-md-6"><strong>Special Price To:</strong> {{ $product->special_price_to ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12"><strong>URL Key:</strong> {{ $product->url_key }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12"><strong>Short Description:</strong> {!! $product->short_description !!}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12"><strong>Description:</strong> {!! $product->description !!}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4"><strong>Meta Title:</strong> {{ $product->meta_title }}</div>
                <div class="col-md-4"><strong>Meta Tag:</strong> {{ $product->meta_tag }}</div>
                <div class="col-md-4"><strong>Meta Description:</strong> {{ $product->meta_description }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <strong>Categories:</strong>
                    <ul>
                        @foreach($product->categories as $category)
                            <li>{{ $category->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if($product->attributeValues)
            <div class="row mb-3">
                <div class="col-md-12">
                    <strong>Attributes:</strong>
                    <ul>
                        @foreach($product->attributeValues as $value)
                            <li><strong>{{ $value->attribute->attribute_name }}:</strong> {{ $value->value_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="row mb-3">
                <div class="col-md-12">
                    <strong>Related Products:</strong>
                    <ul>
                        @foreach($product->relatedProducts as $related)
                            <li>{{ $related->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row mb-3">
                @if($product->image)
                <div class="col-md-6">
                    <strong>Main Image:</strong><br>
                    <img src="{{ asset('uploads/product/' . $product->image) }}" alt="Main Image" width="200">
                </div>
                @endif

                @if($product->thumbnail)
                <div class="col-md-6">
                    <strong>Thumbnail:</strong><br>
                    <img src="{{ asset('uploads/product/' . $product->thumbnail) }}" alt="Thumbnail" width="100">
                </div>
                @endif
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-4">← Back to List</a>
        </div>
    </div>
</div>
@endsection
