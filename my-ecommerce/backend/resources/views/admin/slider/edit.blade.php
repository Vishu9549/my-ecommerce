@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Slider Edit Form -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Slider</h3>
            </div>

            <form action="{{ route('slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">

                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">Slider Title</label>
                        <input type="text" name="title" value="{{ old('title', $slider->title) }}" class="form-control" id="title" required>
                    </div>

                    <!-- Subtitle -->
                    <div class="form-group">
                        <label for="subtitle">Slider Subtitle</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" class="form-control" id="subtitle">
                    </div>

                    <!-- Existing Image -->
                    @if($slider->image)
                        <div class="form-group">
                            <label>Current Image</label><br>
                            <img src="{{ asset('uploads/sliders/' . $slider->image) }}" alt="Slider Image" width="200">
                        </div>
                    @endif

                    <!-- Upload New Image -->
                    <div class="form-group">
                        <label for="image">Change Image (optional)</label>
                        <input type="file" name="image" class="form-control-file" id="image">
                    </div>
                </div>

                <!-- Submit -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Slider</button>
                    <a href="{{ route('slider.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
