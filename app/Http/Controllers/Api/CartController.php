<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::all();

        if ($cart->isEmpty()) {
            // No data found
            return response()->json([
                'message' => 'No data found',
                'code' => 204, // 204 (No Content) for empty resources
            ]);
        } else {
            // Data found, return resource collection
            return CartResource::collection($cart);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        // Perform validation using FormRequest (modify with your rules)
        try {
            $data = $request->validated();
            // Validation

            // Save data
            $cart = Cart::create($data);

            // return a success response
            return response()->json(['message' => 'Data saved successfully', 'data' => $cart], 201);
        } catch (ValidationException $e) {
            // validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        // Check if data exists using exists() or first():
        if ($cart->exists()) {
            // Data found, proceed with transformation:
            return CartResource::make($cart);
        } else {
            // Data not found, return error:
            return response()->json(['error' => 'Data not found for ID: ' . $cart->id], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        // Perform validation using FormRequest (replace with your specific rules)
        $data = $request->validated();

        // Check if all required fields are present (including totalAmount)
        $requiredFields = ['idUser', 'idProduct', 'quantity', 'totalAmount','status'];
        $missingFields = array_diff($requiredFields, array_keys($data));

        if (empty($missingFields)) {
            // All required fields present, update and save
            $cart->fill($data);
            $cart->save();

            // Additional logic (if applicable)
            // - Check product availability and adjust quantity if needed
            // - Notify user of cart changes
            // - Trigger events for order processing or other actions

            return response()->json(['message' => 'Cart updated successfully'], 200);
        } else {
            // Some required fields missing, return appropriate error message
            $missingFieldString = implode(', ', $missingFields);
            return response()->json(['message' => "Please provide all required fields: $missingFieldString"], 422);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {

        // Attempt to delete the data
        if ($cart->delete()) {
            // Delete successful
            return response()->json([
                'message' => 'Data berhasil dihapus',
                'code' => 200,
            ]);
        } else {
            // Delete failed
            return response()->json([
                'error' => 'Data gagal dihapus',
                'code' => 500,
                'details' => $cart->getErrors(),
            ]);
        }
    }
}
