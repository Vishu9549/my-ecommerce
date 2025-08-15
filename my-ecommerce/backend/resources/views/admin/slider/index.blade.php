@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Section List Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Slider List</h3>
                <div class="card-tools">
                    <a href="{{ route('slider.create') }}" class="btn btn-sm btn-primary">Add Slider</a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sliders as $slider)
                        <tr>
                            <td>{{ $slider->id }}</td>
                            <td>{{ $slider->title }}</td>
                            <td>{{ $slider->subtitle }}</td>
                            <td>
                                @if($slider->image)
                                    <img src="{{ asset('uploads/sliders/' . $slider->image) }}" width="80" height="50" alt="Slider Image">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('slider.edit', $slider->id) }}" class="btn btn-sm btn-info">Edit</a>
                                
                                <form action="{{ route('slider.destroy', $slider->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this slider?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No slider found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
