@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Blocks List</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.blocks.create') }}" class="btn btn-primary mb-3">Add New Block</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Identifier</th>
                <th>Title</th>
                <th>Heading</th>
                <th>Description</th>
                <th>Image</th>
                <th>Features</th>
                <th>Status</th>
                <th>Ordering</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blocks as $key => $block)
                @php
                    // Safely extract status even if array
                    $statusValue = is_array($block->status) ? (int)($block->status[0] ?? 0) : (int)$block->status;

                    $badgeClass = match($statusValue) {
                        1 => 'success',
                        0 => 'secondary',
                        default => 'warning'
                    };

                    $statusText = match($statusValue) {
                        1 => 'Active',
                        0 => 'Inactive',
                        default => 'Unknown'
                    };
                @endphp

                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $block->identifier }}</td>
                    <td>{{ $block->title }}</td>
                    <td>{{ $block->heading }}</td>
                    <td>{{ Str::limit(strip_tags($block->description), 60) }}</td>
                    <td>
                        @if($block->image)
                            <img src="{{ asset('storage/' . $block->image) }}" width="80">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($block->features)
                            <ul>
                                @foreach(json_decode($block->features) as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">No features</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $badgeClass }}">{{ $statusText }}</span>
                    </td>
                    <td>{{ $block->ordering }}</td>
                    <td>
                        <a href="{{ route('admin.blocks.edit', $block->id) }}" class="btn btn-sm btn-info">Edit</a>

                        <form action="{{ route('admin.blocks.destroy', $block->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this block?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if($blocks->isEmpty())
                <tr>
                    <td colspan="10" class="text-center text-muted">No blocks found.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
