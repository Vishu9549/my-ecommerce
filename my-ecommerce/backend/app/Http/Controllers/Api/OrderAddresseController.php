<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderAddresse;
use Illuminate\Support\Facades\Validator;

class OrderAddresseController extends Controller
{
    public function index()
    {
        $addresses = OrderAddresse::all();
        return response()->json($addresses);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'address_2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'pincode' => 'nullable|string',
            'address_type' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $address = OrderAddresse::create($request->all());

        return response()->json([
            'message' => 'Order address created successfully',
            'data' => $address
        ], 201);
    }

    public function show($id)
    {
        $address = OrderAddresse::find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        return response()->json($address);
    }

    public function update(Request $request, $id)
    {
        $address = OrderAddresse::find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'name' => 'sometimes|required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'address_2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'pincode' => 'nullable|string',
            'address_type' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address->update($request->all());

        return response()->json([
            'message' => 'Order address updated successfully',
            'data' => $address
        ]);
    }

    public function destroy($id)
    {
        $address = OrderAddresse::find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete();

        return response()->json(['message' => 'Order address deleted successfully']);
    }
}
