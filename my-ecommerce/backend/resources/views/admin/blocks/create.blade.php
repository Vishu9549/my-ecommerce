@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md offset-md">
        <div class="card">
            <div class="card-header">
                <h4>Add New Block</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('blocks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- Left Column --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Heading</label>
                                <input type="text" name="heading" class="form-control" value="{{ old('heading') }}" required>
                                @error('heading') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Ordering</label>
                                <input type="number" name="ordering" class="form-control" value="{{ old('ordering', 0) }}" required>
                                @error('ordering') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Identifier (slug)</label>
                                <input type="text" name="identifier" class="form-control" value="{{ old('identifier') }}">
                                @error('identifier') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Features</label>
                                <div id="feature-wrapper">
                                    <div class="d-flex mb-2">
                                        <input type="text" name="features[]" class="form-control me-2" placeholder="Enter feature">
                                        <button type="button" class="btn btn-sm btn-success add-feature">+</button>
                                    </div>
                                </div>
                                @error('features') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Upload Images</label>
                                <input type="file" name="images[]" class="form-control" multiple required>
                                @error('images') <small class="text-danger">{{ $message }}</small> @enderror
                                @error('images.*') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Save Block</button>
                    <a href="{{ route('blocks.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('feature-wrapper');

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('add-feature')) {
                e.preventDefault();
                const newField = document.createElement('div');
                newField.classList.add('d-flex', 'mb-2');
                newField.innerHTML = `
                    <input type="text" name="features[]" class="form-control me-2" placeholder="Enter feature">
                    <button type="button" class="btn btn-sm btn-danger remove-feature">–</button>
                `;
                wrapper.appendChild(newField);
            }

            if (e.target.classList.contains('remove-feature')) {
                e.preventDefault();
                e.target.parentElement.remove();
            }
        });
    });
</script>
@endsection
