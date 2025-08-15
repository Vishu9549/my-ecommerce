@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Blocks List</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Create button --}}
    <a href="{{ route('blocks.create') }}" class="btn btn-primary mb-3">Add New Block</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Heading</th>
                <th>Images</th>
                <th>Ordering</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($blocks as $block)
                <tr>
                    <td>{{ $block->title }}</td>
                    <td>{{ $block->heading }}</td>
                    <td>
                        {{-- Show multiple images --}}
                        @if(is_array($block->image))
                            @foreach ($block->image as $img)
                                <img src="{{ asset('uploads/blocks/' . $img) }}" width="80" height="80" class="m-1" alt="Image">
                            @endforeach
                        @elseif(is_string($block->image))
                            @foreach (json_decode($block->image, true) ?? [] as $img)
                                <img src="{{ asset('uploads/blocks/' . $img) }}" width="80" height="80" class="m-1" alt="Image">
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $block->ordering }}</td>
                    <td>{{ $block->status ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('blocks.edit', $block->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('blocks.destroy', $block->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No blocks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $blocks->links() }}
    </div>
</div>
@endsection
