@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Attribute</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Attribute Name</label>
                    <input type="text" name="attribute_name" class="form-control" value="{{ $attribute->attribute_name }}"
                        required>
                </div>
                <div class="col-md-6">
                    <label>Name Key</label>
                    <input type="text" name="name_key" class="form-control" value="{{ $attribute->name_key }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Is Variant</label>
                    <select name="is_variant" class="form-control">
                        <option value="1" {{ $attribute->is_variant ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$attribute->is_variant ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $attribute->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$attribute->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <hr>
            <h5>Attribute Values</h5>

            <div id="value-repeater">
                @foreach($attribute->values as $index => $value)
                    <div class="row mb-2 value-group">
                        <input type="hidden" name="values[{{ $index }}][id]" value="{{ $value->id }}">
                        <div class="col-md-6">
                            <input type="text" name="values[{{ $index }}][value]" class="form-control"
                                value="{{ $value->value_name }}" placeholder="Value Name">
                        </div>
                        <div class="col-md-4">
                            <select name="values[{{ $index }}][status]" class="form-control">
                                <option value="1" {{ $value->status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$value->status ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-value">X</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-sm btn-secondary mb-3" id="add-value">+ Add More</button>

            <button type="submit" class="btn btn-primary d-block">Update Attribute</button>
        </form>
    </div>

    <script>
        let valueIndex = {{ count($attribute->values) }};
        document.getElementById('add-value').addEventListener('click', function () {
            const html = `
            <div class="row mb-2 value-group">
                <div class="col-md-6">
                    <input type="text" name="values[${valueIndex}][value]" class="form-control" placeholder="Value Name">
                </div>
                <div class="col-md-4">
                    <select name="values[${valueIndex}][status]" class="form-control">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-value">X</button>
                </div>
            </div>`;
            document.getElementById('value-repeater').insertAdjacentHTML('beforeend', html);
            valueIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-value')) {
                e.target.closest('.value-group').remove();
            }
        });
    </script>
@endsection