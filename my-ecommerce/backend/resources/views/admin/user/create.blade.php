@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New User</h3>
                </div>

                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">User Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Enter user name" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Enter password" required>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="password_confirmation" placeholder="Confirm password" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="Enter email" required>
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control" required>
                                        <option value="">-- Select Role --</option>
                                        <option value="admin">Admin</option>
                                        <option value="editor">Editor</option>
                                        <option value="test">Test</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection