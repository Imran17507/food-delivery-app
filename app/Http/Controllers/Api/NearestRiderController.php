<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Rider;
use App\Models\RiderLocationHistory;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NearestRiderController extends Controller
{
    public function nearestRider(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                    'status' => 'error'
                ], Response::HTTP_BAD_REQUEST);
            }

            $validatedData = $validator->validated();
            $restaurantId = $validatedData['restaurant_id'];

            $restaurant = Restaurant::findOrFail($restaurantId);
            $restaurantLat = $restaurant->latitude;
            $restaurantLon = $restaurant->longitude;

            $nearestRider = RiderLocationHistory::select(DB::raw("rider_id, latitude, longitude, ( 6371 * acos( cos( radians($restaurantLat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($restaurantLon) ) + sin( radians($restaurantLat) ) * sin(radians(latitude)) ) ) AS distance_from_restaurant_in_km"))
                                ->where('capture_time', '>=', now()->subSeconds(1))
                                ->orderBy('distance_from_restaurant_in_km', 'ASC')
                                ->first();

            if (is_null($nearestRider)) {
                $nearestRider = RiderLocationHistory::select(DB::raw("rider_id, latitude, longitude, ( 6371 * acos( cos( radians($restaurantLat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($restaurantLon) ) + sin( radians($restaurantLat) ) * sin(radians(latitude)) ) ) AS distance_from_restaurant_in_km"))
                                    ->where('capture_time', '>=', now()->subMinutes(5))
                                    ->orderBy('distance_from_restaurant_in_km', 'ASC')
                                    ->first();
            }

            if (is_null($nearestRider)) {
                return response()->json([
                    'message' => 'No nearby rider found',
                    'status' => 'failed'
                ], Response::HTTP_NOT_FOUND);
            }

            $rider = Rider::findOrFail($nearestRider->rider_id);
            $nearestRider->name = $rider->first_name . " " . $rider->last_name;
            $nearestRider->contact_no = $rider->contact_no;

            return response()->json([
                'message' => 'Nearest rider found',
                'data' => $nearestRider,
                'status' => 'success'
            ], Response::HTTP_OK);
        } catch (Exception | QueryException $e) {
            Log::error('Exception in NearestRiderController@nearestRider', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
            ]);

            return response()->json([
                'message' => 'An error occurred determining the nearest rider location',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
