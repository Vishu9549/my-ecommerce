@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Add We Help Section</h2>

    <form action="{{ route('we-help.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Heading</label>
            <input type="text" name="heading" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label>Features (enter 4)</label>
            @for($i = 0; $i < 4; $i++)
                <input type="text" name="features[]" class="form-control mb-1" required>
            @endfor
        </div>

        <div class="mb-3">
            <label>Button Text</label>
            <input type="text" name="button_text" class="form-control">
        </div>

        <div class="mb-3">
            <label>Button Link</label>
            <input type="url" name="button_link" class="form-control">
        </div>

        <div class="mb-3">
            <label>Image 1</label>
            <input type="file" name="image_1" class="form-control">
        </div>

        <div class="mb-3">
            <label>Image 2</label>
            <input type="file" name="image_2" class="form-control">
        </div>

        <div class="mb-3">
            <label>Image 3</label>
            <input type="file" name="image_3" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
