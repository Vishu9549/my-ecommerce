@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add Role</h3>
                        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary float-right">Back</a>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input type="text" name="role_name" id="role_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label><strong>Permissions</strong></label>
                            <div class="row">
                                @foreach ($allPermissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permission[]"
                                                value="{{ $permission }}" id="perm_{{ $loop->index }}">
                                            <label class="form-check-label" for="perm_{{ $loop->index }}">
                                                {{ ucwords(str_replace('_', ' ', $permission)) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary">Save Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection