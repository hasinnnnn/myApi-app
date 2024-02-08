<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Validation\ValidationException;

class ProductUpdated
{
    // Define properties and methods for your ProductUpdated class
}

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            $product = Product::all();

            if ($product->isEmpty()) {
                // No data found
                return response()->json([
                    'message' => 'No data found',
                    'code' => 204, // 204 (No Content) for empty resources
                ]);
            } else {
                // Data found, return resource collection
                return ProductResource::collection($product);
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
    public function store(StoreProductRequest $request)
        {
            // Perform validation using FormRequest (modify with your rules)
            try {
                $data = $request->validated();
                // Validation

                // Save data
                $product = Product::create($data);

                // return a success response
                return response()->json(['message' => 'Data saved successfully', 'data' => $product], 201);
            } catch (ValidationException $e) {
                // validation errors
                return response()->json(['errors' => $e->errors()], 422);
            }
        }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
        {
            // Check if data exists using exists() or first():
            if ($product->exists()) {
                // Data found, proceed with transformation:
                return ProductResource::make($product);
            } else {
                // Data not found, return error:
                return response()->json(['error' => 'Data not found for ID: ' . $product->id], 404);
            }
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


     public function update(UpdateProductRequest $request, Product $product)
        {
            // Perform validation using FormRequest (modify with your rules)
            $data = $request->validated();

            // Check if all required fields are present
            $requiredFields = ['productName', 'price', 'stock', 'description', 'status'];
            $missingFields = array_diff($requiredFields, array_keys($data));

            if (empty($missingFields)) {
                // All required fields present, update and save
                $product->fill($data);

                // Handle images separately (consider using a dedicated service/module)
                if (isset($data['images'])) {
                    // Process image uploads and update product images field
                    // ... (your logic for handling images goes here)
                    // $product->images = $processedImagesArray;
                }


                $product->save();

                // ... any other logic you might need after product update

                return response()->json(['message' => 'Product updated successfully'], 200);
            } else {
                // Some required fields missing, return appropriate error message
                $missingFieldString = implode(', ', $missingFields);
                return response()->json(['message' => "Please provide all required fields: $missingFieldString"], 422);
            }
        }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
        {

            // Attempt to delete the data
            if ($product->delete()) {
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
                    'details' => $product->getErrors(),
                ]);
            }
        }
}
