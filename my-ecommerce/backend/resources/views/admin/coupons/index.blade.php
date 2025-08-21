@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Coupon List</h3>
            <a href="{{ route('coupons.create') }}" class="btn btn-primary">Add Coupon</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Coupon Code</th>
                    <th>Valid From</th>
                    <th>Valid To</th>
                    <th>Discount Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $index => $coupon)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $coupon->title }}</td>
                        <td>
                            <span class="badge bg-{{ $coupon->status ? 'success' : 'secondary' }}">
                                {{ $coupon->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $coupon->coupon_code }}</td>
                        <td>{{ $coupon->valid_from }}</td>
                        <td>{{ $coupon->valid_to }}</td>
                        <td>{{ $coupon->discount_amount }}</td>
                        <td>
                            <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Delete this coupon?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $coupons->links() }}
    </div>
@endsection