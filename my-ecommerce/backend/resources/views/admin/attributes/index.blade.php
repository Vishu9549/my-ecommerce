@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Attribute List</h4>
            <a href="{{ route('attributes.create') }}" class="btn btn-primary">Add Attribute</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Attribute Name</th>
                            <th>Name Key</th>
                            <th>Is Variant</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attributes as $index => $attribute)
                            <tr>
                                <td>{{ $attributes->firstItem() + $index }}</td>
                                <td>{{ $attribute->attribute_name }}</td>
                                <td>{{ $attribute->name_key }}</td>
                                <td>{{ $attribute->is_variant ? 'Yes' : 'No' }}</td>
                                <td>
                                    <span class="badge badge-{{ $attribute->status ? 'success' : 'secondary' }}">
                                        {{ $attribute->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('attributes.show', $attribute->id) }}"
                                        class="btn btn-sm btn-info">Show</a>
                                    <a href="{{ route('attributes.edit', $attribute->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST"
                                        class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No attributes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-3">
                    {{ $attributes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection