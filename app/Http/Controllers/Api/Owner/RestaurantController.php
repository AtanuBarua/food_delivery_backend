<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Http\Resources\RestaurantCollection;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function addRestaurant(RestaurantRequest $request)
    {
        $status_code = 500;
        $status_message = 'Something went wrong';

        try {
            $data = $request->validated();
            $status = (new Restaurant())->store($data);
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
        $data['status'] = false;
        $status_code = 200;

        try {
            $restaurant = (new Restaurant())->findRestaurantById($id);
            if (!empty($restaurant)) {
                $data['restaurant'] = new RestaurantResource($restaurant);
                $data['status'] = true;
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

    public function updateRestaurant(RestaurantRequest $request, $id) {
        $status_code = 500;
        $status_message = 'Something went wrong';

        try {
            $data = $request->validated();
            $restaurant = new Restaurant();
            $restaurantObj = $restaurant->findRestaurantById($id);
            $status = $restaurant->updateRestaurant($data, $restaurantObj);
            if ($status) {
                $status_code = 200;
                $status_message = 'Updated successfully';
            }
        } catch (\Throwable $th) {
            \Log::error("message", [$th->getMessage()]);
        }

        return response()->json([
            'message' => $status_message
        ], $status_code);
    }
}
