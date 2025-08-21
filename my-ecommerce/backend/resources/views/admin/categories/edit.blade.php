@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Edit Category</h2>

        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-md-6">

                    <div class="form-group mb-3">
                        <label for="parent_id">Select Parent Category</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- None --</option>
                            @foreach($categories as $parent)
                                <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="status">Select Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $category->status == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="show_in_menu">Show in Menu</label>
                        <select name="show_in_menu" class="form-control">
                            <option value="1" {{ $category->show_in_menu == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $category->show_in_menu == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="short_description">Short Description</label>
                        <textarea name="short_description" rows="3"
                            class="form-control">{{ old('short_description', $category->short_description) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="url_key">URL Key</label>
                        <input type="text" name="url_key" class="form-control"
                            value="{{ old('url_key', $category->url_key) }}">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group mb-3">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control"
                            value="{{ old('meta_title', $category->meta_title) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="meta_tag">Meta Tag</label>
                        <input type="text" name="meta_tag" class="form-control"
                            value="{{ old('meta_tag', $category->meta_tag) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" rows="3"
                            class="form-control">{{ old('meta_description', $category->meta_description) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" rows="4"
                            class="form-control">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control">
                        @if($category->image)
                            <img src="{{ asset('uploads/categories/' . $category->image) }}" width="80" class="mt-2">
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="products">Assigned Products</label>
                        <select name="products[]" class="form-control" multiple>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ in_array($product->id, $categoryProductIds) ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>

            <div class="form-group mt-3">
                <button class="btn btn-success">Update Category</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection