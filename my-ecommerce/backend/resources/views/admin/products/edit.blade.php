@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Is Featured</label>
                    <select name="is_featured" class="form-control">
                        <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ $product->sku }}">
                </div>

                <div class="form-group mb-3">
                    <label>Quantity</label>
                    <input type="number" name="qty" class="form-control" value="{{ $product->qty }}">
                </div>

                <div class="form-group mb-3">
                    <label>Stock Status</label>
                    <select name="stock_status" class="form-control">
                        <option value="in_stock" {{ $product->stock_status == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="out_stock" {{ $product->stock_status == 'out_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Weight</label>
                    <input type="text" name="weight" class="form-control" value="{{ $product->weight }}">
                </div>

                <div class="form-group mb-3">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}">
                </div>

                <div class="form-group mb-3">
                    <label>Special Price</label>
                    <input type="number" step="0.01" name="special_price" class="form-control" value="{{ $product->special_price }}">
                </div>

                <div class="form-group mb-3">
                    <label>Special Price From</label>
                    <input type="datetime-local" name="special_price_from" class="form-control" value="{{ $product->special_price_from }}">
                </div>

                <div class="form-group mb-3">
                    <label>Special Price To</label>
                    <input type="datetime-local" name="special_price_to" class="form-control" value="{{ $product->special_price_to }}">
                </div>

                <div class="form-group mb-3">
                    <label>URL Key</label>
                    <input type="text" name="url_key" class="form-control" value="{{ $product->url_key }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>Short Description</label>
                    <textarea name="short_description" class="form-control" rows="2">{{ $product->short_description }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="5">{{ $product->description }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ $product->meta_title }}">
                </div>

                <div class="form-group mb-3">
                    <label>Meta Tag</label>
                    <input type="text" name="meta_tag" class="form-control" value="{{ $product->meta_tag }}">
                </div>

                <div class="form-group mb-3">
                    <label>Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ $product->meta_description }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Product Image</label><br>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" width="100"><br><br>
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Thumbnail Image</label><br>
                    @if ($product->thumbnail_image)
                        <img src="{{ asset('storage/' . $product->thumbnail_image) }}" width="100"><br><br>
                    @endif
                    <input type="file" name="thumbnail_image" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Categories</label><br>
                    @foreach ($categories as $category)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                                {{ $product->categories->contains($category->id) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="form-group mb-3">
    <label><strong>Attributes</strong></label>
    @foreach ($attributes as $attribute)
        <div class="mb-3">
            <label class="d-block"><strong>{{ $attribute->attribute_name }}</strong></label>
            @foreach ($attribute->values as $value)
                <div class="form-check form-check-inline">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        name="attribute_values[]" 
                        value="{{ $value->id }}"
                        {{ $product->attributeValues->contains('id', $value->id) ? 'checked' : '' }}
                        id="attribute_{{ $value->id }}"
                    >
                    <label class="form-check-label" for="attribute_{{ $value->id }}">
                        {{ $value->value_name }}
                    </label>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

                <div class="form-group">
    <label for="related_products">Related Products</label>
    <select name="related_products[]" class="form-control" multiple>
        @foreach ($allProducts as $p)
            @if (!isset($product) || $product->id !== $p->id)
                <option value="{{ $p->id }}"
                    @if(isset($product) && $product->relatedProducts->contains($p->id)) selected @endif>
                    {{ $p->name }}
                </option>
            @endif
        @endforeach
    </select>
</div>

            </div>
        </div>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success">Update Product</button>
        </div>
    </form>
</div>
@endsection
