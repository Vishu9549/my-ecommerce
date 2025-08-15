@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Customers</h2>

   

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th style="width: 50px;">#</th>
                <th>Name</th>
                <th>Email</th>
                <th style="width: 150px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $index => $customer)
                <tr>
                    <td>{{ $customers->firstItem() + $index }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info">View</a>
                        <!-- Add Edit/Delete if needed -->
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No customers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} entries
    </div>

    <div class="mt-2">
        {{ $customers->links() }}
    </div>
</div>
@endsection
