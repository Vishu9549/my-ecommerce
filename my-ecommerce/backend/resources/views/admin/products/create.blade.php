@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Is Featured</label>
                    <select name="is_featured" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>SKU</label>
                    <input type="text" name="sku" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Quantity</label>
                    <input type="number" name="qty" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Stock Status</label>
                    <select name="stock_status" class="form-control">
                        <option value="in_stock">In Stock</option>
                        <option value="out_stock">Out of Stock</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Weight</label>
                    <input type="text" name="weight" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Special Price</label>
                    <input type="number" step="0.01" name="special_price" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Special Price From</label>
                    <input type="datetime-local" name="special_price_from" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Special Price To</label>
                    <input type="datetime-local" name="special_price_to" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>URL Key</label>
                    <input type="text" name="url_key" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>Short Description</label>
                    <textarea name="short_description" class="form-control" rows="2"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="5"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Meta Tag</label>
                    <input type="text" name="meta_tag" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Product Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Thumbnail Image</label>
                    <input type="file" name="thumbnail_image" class="form-control">

                </div>

                <div class="form-group mb-3">
                    <label>Categories</label><br>
                    @foreach ($categories as $category)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}">
                            <label class="form-check-label">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>

               <div class="form-group mb-3">
    <label><strong>Attributes</strong></label>
    @foreach ($attributes as $attribute)
        <div class="mb-3">
            <label class="form-label d-block"><strong>{{ $attribute->attribute_name }}</strong></label>
            @foreach ($attribute->values as $value)
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="attribute_values[]"
                        value="{{ $value->id }}"
                        id="attr_{{ $attribute->id }}_val_{{ $value->id }}"
                        {{ in_array($value->id, old('attribute_values', $selectedAttributeValues ?? [])) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="attr_{{ $attribute->id }}_val_{{ $value->id }}">
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
            <button type="submit" class="btn btn-primary">Create Product</button>
        </div>
    </form>
</div>
@endsection
