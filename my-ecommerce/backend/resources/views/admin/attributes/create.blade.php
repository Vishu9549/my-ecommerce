@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create Attribute</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('attributes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Attribute Name <span class="text-danger">*</span></label>
            <input type="text" name="attribute_name" class="form-control" placeholder="Enter attribute name" value="{{ old('attribute_name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Name Key <span class="text-danger">*</span></label>
            <input type="text" name="name_key" class="form-control" placeholder="Enter name key" value="{{ old('name_key') }}">
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Is Variant <span class="text-danger">*</span></label>
                <select name="is_variant" class="form-control">
                    <option value="1" {{ old('is_variant') == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_variant') == '0' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <hr>
        <h5 class="mt-4 mb-2">Attribute Values</h5>

        <div id="attribute-values-wrapper">
            <div class="row mb-3">
                <div class="col-md-5">
                    <label class="form-label">Value Name</label>
                    <input type="text" name="values[0][value]" class="form-control" placeholder="Value Name">
                </div>
                
                <div class="col-md-5">
                    <label class="form-label">Value Status</label>
                    <select name="values[0][status]" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-success w-100" onclick="addValueRow()">Add</button>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Attribute</button>
        <a href="{{ route('attributes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    let valueIndex = 1;

    function addValueRow() {
        const wrapper = document.getElementById('attribute-values-wrapper');

        const row = document.createElement('div');
        row.classList.add('row', 'mb-3');
        row.innerHTML = `
            <div class="col-md-5">
                <label class="form-label">Value Name</label>
                <input type="text" name="values[${valueIndex}][value]" class="form-control" placeholder="Value Name">
            </div>
            <div class="col-md-5">
                <label class="form-label">Value Status</label>
                <select name="values[${valueIndex}][status]" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger w-100" onclick="this.closest('.row').remove()">Remove</button>
            </div>
        `;
        wrapper.appendChild(row);
        valueIndex++;
    }
</script>
@endsection
