@extends('layouts.admin')
@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4">Attribute Detail</h4>
    <div class="card mb-4">
        <div class="card-header">
            <a href="{{ route('attributes.index') }}" class="btn btn-primary btn-sm float-end">Back</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Attribute Name</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="{{ $attribute->attribute_name }}">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name Key</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="{{ $attribute->name_key }}">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Is Variant</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="{{ $attribute->is_variant ? 'Yes' : 'No' }}">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="{{ $attribute->status ? 'Active' : 'Inactive' }}">
                </div>
            </div>

            @if($attribute->values && $attribute->values->count())
                <h5 class="mt-4">Attribute Values</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Value Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attribute->values as $value)
                            <tr>
                                <td>{{ $value->value_name }}</td>
                                <td>{{ $value->status ? 'Active' : 'Inactive' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No attribute values available.</p>
            @endif
        </div>
    </div>
</div>
@endsection
