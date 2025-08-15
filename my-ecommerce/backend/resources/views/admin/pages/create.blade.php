@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Page Create Form -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Page</h3>
            </div>
            <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Left Side -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Enter Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
                            </div>

                            <div class="form-group">
                                <label for="heading">Enter Heading</label>
                                <input type="text" name="heading" class="form-control" placeholder="Enter Heading">
                            </div>

                            <div class="form-group">
                                <label for="ordering">Enter Ordering</label>
                                <input type="number" name="ordering" class="form-control" placeholder="Enter Ordering">
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Select Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="url_key">Enter URL Key</label>
                                <input type="text" name="url_key" class="form-control" placeholder="Enter URL Key">
                            </div>

                            <div class="form-group">
                                <label for="image">Image Upload</label>
                                <input type="file" name="image" class="form-control-file">
                            </div>
                        </div>
                    </div>

                    <!-- Full-width Description -->
                    <div class="form-group mt-4">
                        <label for="description">Enter Description</label>
                        <textarea name="description" id="description" class="form-control" rows="8" placeholder="Enter Description..."></textarea>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Save Page</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
