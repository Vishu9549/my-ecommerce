@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit We Help Section</h2>

    <form action="{{ route('we-help.update', $section->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Heading</label>
            <input type="text" name="heading" class="form-control" value="{{ $section->heading }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ $section->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Features</label>
            @foreach(json_decode($section->features) as $feature)
                <input type="text" name="features[]" class="form-control mb-1" value="{{ $feature }}" required>
            @endforeach
        </div>

        <div class="mb-3">
            <label>Button Text</label>
            <input type="text" name="button_text" class="form-control" value="{{ $section->button_text }}">
        </div>

        <div class="mb-3">
            <label>Button Link</label>
            <input type="url" name="button_link" class="form-control" value="{{ $section->button_link }}">
        </div>

        <div class="mb-3">
            <label>Image 1</label><br>
            @if($section->image_1)
                <img src="{{ asset('storage/' . $section->image_1) }}" width="80" class="mb-2"><br>
            @endif
            <input type="file" name="image_1" class="form-control">
        </div>

        <div class="mb-3">
            <label>Image 2</label><br>
            @if($section->image_2)
                <img src="{{ asset('storage/' . $section->image_2) }}" width="80" class="mb-2"><br>
            @endif
            <input type="file" name="image_2" class="form-control">
        </div>

        <div class="mb-3">
            <label>Image 3</label><br>
            @if($section->image_3)
                <img src="{{ asset('storage/' . $section->image_3) }}" width="80" class="mb-2"><br>
            @endif
            <input type="file" name="image_3" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
