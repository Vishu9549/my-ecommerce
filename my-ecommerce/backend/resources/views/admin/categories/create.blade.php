@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Create Category</h2>

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-md-6">

                    <div class="form-group mb-3">
                        <label for="parent_id">Select Parent Category</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- None --</option>
                            @foreach($categories as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter category">
                    </div>

                    <div class="form-group mb-3">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="Auto-generated from name">
                    </div>

                    <div class="form-group mb-3">
                        <label for="status">Select Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="show_in_menu">Show in Menu</label>
                        <select name="show_in_menu" class="form-control">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="short_description">Short Description</label>
                        <textarea name="short_description" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="url_key">URL Key</label>
                        <input type="text" name="url_key" class="form-control" placeholder="Enter URL Key">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group mb-3">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" placeholder="Enter meta title">
                    </div>

                    <div class="form-group mb-3">
                        <label for="meta_tag">Meta Tag</label>
                        <input type="text" name="meta_tag" class="form-control" placeholder="Enter meta tag">
                    </div>

                    <div class="form-group mb-3">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" rows="4" class="form-control"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="products">Assign Products</label>
                        <select name="products[]" class="form-control" multiple>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>

            <div class="form-group mt-3">
                <button class="btn btn-primary">Create Category</button>
            </div>
        </form>
    </div>
@endsection