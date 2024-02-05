<?php

namespace App\Http\Controllers\Api;

use App\Models\DataUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataUserResource;
use App\Http\Requests\StoreDataUserRequest;
use App\Http\Requests\UpdateDataUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataUsers = DataUser::all();

        if ($dataUsers->isEmpty()) {
            // No data found
            return response()->json([
                'message' => 'No data found',
                'code' => 204, // 204 (No Content) for empty resources
            ]);
        } else {
            // Data found, return resource collection
            return DataUserResource::collection($dataUsers);
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
    public function store(StoreDataUserRequest $request)
    {
        // Perform validation using FormRequest (modify with your rules)
        try {
            $data = $request->validated();
            // Validation

            // Save data
            $dataUser = DataUser::create($data);

            // return a success response
            return response()->json(['message' => 'Data saved successfully', 'data' => $dataUser], 201);
        } catch (ValidationException $e) {
            // validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(DataUser $dataUser)
    {
        // Check if data exists using exists() or first():
        if ($dataUser->exists()) {
            // Data found, proceed with transformation:
            return DataUserResource::make($dataUser);
        } else {
            // Data not found, return error:
            return response()->json(['error' => 'Data not found for ID: ' . $dataUser->id], 404);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataUser $dataUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataUserRequest $request, DataUser $dataUser)
    {
        // Perform validation using FormRequest (modify with your rules)
        $data = $request->validated();

        // Check if all required fields are present
        if (array_key_exists('name', $data) && array_key_exists('email', $data) &&
            array_key_exists('password', $data) && array_key_exists('phone', $data)) {
            // All fields present, update and save
            $dataUser->fill($data);
            $dataUser->save();
            return response()->json(['message' => 'Data updated successfully'], 200);
        } else {
            // Some fields missing, return appropriate error message
            return response()->json(['message' => 'Please provide all required fields'], 422); // Unprocessable Entity
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataUser $dataUser)
    {

        // Attempt to delete the data
        if ($dataUser->delete()) {
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
                'details' => $dataUser->getErrors(),
            ]);
        }
    }


}
