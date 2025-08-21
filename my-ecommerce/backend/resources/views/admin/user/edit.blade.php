@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
                </div>

                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">User Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="form-control" id="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Leave blank to keep existing">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="password_confirmation" placeholder="Confirm new password">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="form-control" id="email" required>
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control" required>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Editor</option>
                                        <option value="test" {{ $user->role == 'test' ? 'selected' : '' }}>Test</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection