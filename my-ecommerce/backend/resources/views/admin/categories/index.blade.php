@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Card for Category List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Category List</h3>
                <div class="card-tools">
                    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Add Category</a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Parent ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Show in Menu</th>
                            <th>URL Key</th>
                            <th>Meta Title</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->parent_id ?? '-' }}</td>
                            <td>{{ $category->name ?? '-' }}</td>
                            <td>
                                @php
                                    $statusText = $category->status ? 'Active' : 'Inactive';
                                    $statusClass = $category->status ? 'success' : 'secondary';
                                @endphp
                                <span class="badge badge-{{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $category->show_in_menu ? 'info' : 'light' }}">
                                    {{ $category->show_in_menu ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>{{ $category->url_key ?? '-' }}</td>
                            <td>{{ $category->meta_title ?? '-' }}</td>
                             <td>
          <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-info">Show</a>
          <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this category?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No categories found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
