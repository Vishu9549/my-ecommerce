@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Add New Coupon</h3>

    <form action="{{ route('coupons.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                </div>

                <div class="mb-3">
                    <label>Coupon Code</label>
                    <input type="text" name="coupon_code" class="form-control" value="{{ old('coupon_code') }}">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label>Valid From</label>
                    <input type="date" name="valid_from" class="form-control" value="{{ old('valid_from') }}">
                </div>

                <div class="mb-3">
                    <label>Valid To</label>
                    <input type="date" name="valid_to" class="form-control" value="{{ old('valid_to') }}">
                </div>

                <div class="mb-3">
                    <label>Discount Amount</label>
                    <input type="number" name="discount_amount" class="form-control" value="{{ old('discount_amount') }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
