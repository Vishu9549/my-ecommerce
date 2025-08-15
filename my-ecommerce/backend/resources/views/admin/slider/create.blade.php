@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Slider</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Title -->
                        <div class="form-group col-md-6">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <!-- Subtitle -->
                        <div class="form-group col-md-6">
                            <label>Subtitle</label>
                            <input type="text" name="subtitle" class="form-control">
                        </div>

                        <!-- Image -->
                        <div class="form-group col-md-6">
                            <label>Slider Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Slider</button>
                    <a href="{{ route('slider.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
