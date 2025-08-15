@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Block</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('blocks.update', $block->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Title -->
                            <div class="form-group">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $block->title) }}" required>
                            </div>

                            <!-- Heading -->
                            <div class="form-group">
                                <label>Heading <span class="text-danger">*</span></label>
                                <input type="text" name="heading" class="form-control" value="{{ old('heading', $block->heading) }}" required>
                            </div>

                            <!-- Ordering -->
                            <div class="form-group">
                                <label>Ordering</label>
                                <input type="number" name="ordering" class="form-control" value="{{ old('ordering', $block->ordering) }}">
                            </div>

                            <!-- Identifier -->
                            <div class="form-group">
                                <label>Identifier</label>
                                <input type="text" name="identifier" class="form-control" value="{{ old('identifier', $block->identifier) }}">
                            </div>

                            <!-- Features -->
                            <div class="form-group">
                                <label>Features (Add/Remove)</label>
                                <div id="features-wrapper">
                                    @foreach (json_decode($block->features, true) ?? [] as $feature)
                                        <div class="input-group mb-2 feature-input">
                                            <input type="text" name="features[]" class="form-control" value="{{ $feature }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger remove-feature">×</button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="input-group mb-2 feature-input">
                                        <input type="text" name="features[]" class="form-control" placeholder="Add new feature">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-feature">×</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="add-feature" class="btn btn-sm btn-outline-primary mt-2">Add More</button>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Status -->
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $block->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $block->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Multiple Image Uploads -->
                            @foreach(['image', 'image_1', 'image_2', 'image_3'] as $img)
                                <div class="form-group">
                                    <label>{{ ucfirst(str_replace('_', ' ', $img)) }}</label>
                                    <input type="file" name="{{ $img }}" class="form-control-file">
                                    @if ($block->$img)
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/blocks/' . $block->$img) }}" width="120" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group mt-4">
                        <label>Description</label>
                        <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', $block->description) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Update Block</button>
                    <a href="{{ route('blocks.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(console.error);

    // Add new feature input
    document.getElementById('add-feature').addEventListener('click', () => {
        const wrapper = document.getElementById('features-wrapper');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 feature-input';
        div.innerHTML = `
            <input type="text" name="features[]" class="form-control" placeholder="Add another feature">
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-feature">×</button>
            </div>
        `;
        wrapper.appendChild(div);
    });

    // Remove feature input
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-feature')) {
            const group = e.target.closest('.feature-input');
            group.remove();
        }
    });
</script>
@endsection
