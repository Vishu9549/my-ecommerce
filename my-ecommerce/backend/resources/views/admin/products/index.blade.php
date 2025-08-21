@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Product List</h4>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        </div>

        <form action="{{ route('products.index') }}" method="GET" class="mb-3">
            <div class="input-group" style="max-width: 300px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Search products...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Status</th>
                                <th>Is Featured</th>
                                <th>Qty</th>
                                <th>Stock Status</th>
                                <th>Weight</th>
                                <th>Price</th>
                                <th>Special Price</th>
                                <th>Special From</th>
                                <th>Special To</th>
                                <th>Image</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $index }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $product->status ? 'success' : 'secondary' }}">
                                            {{ $product->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>{{ $product->stock_status }}</td>
                                    <td>{{ $product->weight }} kg</td>
                                    <td>₹{{ $product->price }}</td>
                                    <td>₹{{ $product->special_price ?? '-' }}</td>
                                    <td>{{ $product->special_price_from ?? '-' }}</td>
                                    <td>{{ $product->special_price_to ?? '-' }}</td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('uploads/product/' . $product->image) }}" width="80" height="50"
                                                alt="product Image">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="btn btn-sm btn-info">Show</a>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center text-muted">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection