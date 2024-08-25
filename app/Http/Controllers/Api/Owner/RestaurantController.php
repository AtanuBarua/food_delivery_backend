<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\Request;

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
}
