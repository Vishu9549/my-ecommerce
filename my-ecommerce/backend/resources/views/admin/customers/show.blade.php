@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Customer Details</h2>
    <hr>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Customer Name:</strong>{{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $customer->address ?? 'N/A' }}</p>
        </div>
    </div>

    <h3>Customer Orders</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->order_increment_id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <a href="{{ route('order.show', $customer->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
              
                
              
               
            </tbody>
        </table>
    </div>

    {{-- Pagination links --}}
  

    <a href="{{ route('customers.index') }}" class="btn btn-secondary mt-3">Back to Customers</a>
</div>
@endsection
