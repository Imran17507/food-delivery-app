<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RiderLocationHistory;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RiderLocationHistoryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'rider_id' => 'required|integer',
                'service_name' => 'required|string|max:32',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'capture_time' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                    'status' => 'error'
                ], Response::HTTP_BAD_REQUEST);
            }

            $validatedData = $validator->validated();

            $riderLocationHistory = new RiderLocationHistory($validatedData);
            $riderLocationHistory->save();

            return response()->json([
                'message' => 'Rider location history stored successfully',
                'data' => $riderLocationHistory,
                'status' => 'success'
            ], Response::HTTP_CREATED);
        } catch (Exception | QueryException $e) {
            Log::error('Exception in RiderLocationHistoryController@store', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
            ]);

            return response()->json([
                'message' => 'An error occurred while storing the rider location',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
