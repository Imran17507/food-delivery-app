<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RiderLocationHistory;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RiderLocationHistoryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'rider_id' => 'required|integer',
                'service_name' => 'required|string|max:32',
                'latitude' => 'required|decimal:0,6',
                'longitude' => 'required|decimal:0,6',
                'capture_time' => 'required|date'
            ]);

            $riderLocationHistory = new RiderLocationHistory($validatedData);
            $riderLocationHistory->save();

            return response()->json([
                'message' => 'Rider location stored successfully',
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
