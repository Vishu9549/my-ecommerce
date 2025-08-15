@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Permission List Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Permission List</h3>
                <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-primary">Add Permission</a>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('permissions.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search permission..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i> <!-- Font Awesome search icon -->
                            </button>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Permission Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $key => $permission)
                            <tr>
                                <td>{{ $permissions->firstItem() + $key }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">No permissions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $permissions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
