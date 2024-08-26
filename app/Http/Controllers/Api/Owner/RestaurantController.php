<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRestaurantRequest;
use App\Http\Resources\RestaurantCollection;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function addRestaurant(CreateRestaurantRequest $request)
    {
        $status_code = 500;
        $status_message = 'Something went wrong';

        try {
            $status = (new Restaurant())->store($request->all());
            if ($status) {
                $status_code = 200;
                $status_message = 'Restaurant created successfully';
            }
        } catch (\Throwable $th) {
            \Log::error("message", [$th->getMessage()]);
        }

        return response()->json([
            'message' => $status_message,
        ], $status_code);
    }

    public function getRestaurants()
    {
        $status_code = 500;
        $status_message = 'Something went wrong';
        $data = [];

        try {
            $restaurants = (new Restaurant())->getRestaurantsByOwnerId(auth()->id());
            $data['restaurants'] = new RestaurantCollection($restaurants);
            $status_code = 200;
            $status_message = 'Successfully fetched';
        } catch (\Throwable $th) {
            \Log::error("message", [$th->getMessage()]);
        }

        return response()->json([
            'message' => $status_message,
            'data' => $data
        ], $status_code);
    }

    public function restaurantDetails($id) {
        $data = [];
        $status_code = 200;

        try {
            $restaurant = (new Restaurant())->findRestaurantById($id);
            if (!empty($restaurant)) {
                $data['restaurant'] = new RestaurantResource($restaurant);
            }
            $this->authorize('view', $restaurant);
            $data['status_message'] = !empty($data['restaurant']) ? 'Successful' : 'Not found';
        } catch (\Throwable $th) {
            $data['status_message'] = $th->getMessage();
            \Log::error("message", [$data['status_message']]);
            $status_code = 500;
        }

        return response()->json([
            'data' => $data,
        ], $status_code);
    }
}
