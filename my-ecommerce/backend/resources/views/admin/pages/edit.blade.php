@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Page</h3>
                </div>

                <div class="card-body row">
                    <!-- Left Side -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Enter Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Enter Heading</label>
                            <input type="text" name="heading" class="form-control" value="{{ old('heading', $page->heading) }}">
                        </div>

                        <div class="form-group">
                            <label>Enter Ordering</label>
                            <input type="number" name="ordering" class="form-control" value="{{ old('ordering', $page->ordering) }}">
                        </div>

                        <div class="form-group">
                            <label>Select Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $page->status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$page->status ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Enter URL Key</label>
                            <input type="text" name="url_key" class="form-control" value="{{ old('url_key', $page->url_key) }}">
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image Upload</label>
                            <input type="file" name="image" class="form-control-file">
                            @if($page->image)
                                <img src="{{ asset('storage/' . $page->image) }}" alt="Current Image" width="100" class="mt-2">
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Enter Description</label>
                            <textarea name="description" id="editor" class="form-control" rows="6">{{ old('description', $page->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Update Page</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/46.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
