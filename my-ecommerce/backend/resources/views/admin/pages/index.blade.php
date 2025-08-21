@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Page List</h3>
                    <div class="card-tools">
                        <a href="{{ route('pages.create') }}" class="btn btn-sm btn-primary">Add Page</a>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Heading</th>
                                <th>Ordering</th>
                                <th>Status</th>
                                <th>URL Key</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pages as $page)
                                <tr>
                                    <td>{{ $page->id }}</td>
                                    <td>{{ $page->title }}</td>
                                    <td>{{ $page->heading }}</td>
                                    <td>{{ $page->ordering }}</td>
                                    <td>
                                        @php
                                            $badgeClass = $page->status ? 'success' : 'secondary';
                                            $statusText = $page->status ? 'Active' : 'Inactive';
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>{{ $page->url_key }}</td>
                                    <td>
                                        @if($page->image)
                                            <img src="{{ asset('uploads/pages/' . $page->image) }}" width="80" height="50"
                                                alt="Page Image">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-sm btn-info">Edit</a>

                                        <form action="{{ route('pages.destroy', $page->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this page?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No pages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection