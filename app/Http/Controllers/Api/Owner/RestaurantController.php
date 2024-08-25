<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRestaurantRequest;
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
            $data['restaurants'] = (new Restaurant())->getRestaurantsByOwnerId(auth()->id());
            foreach ($data['restaurants'] as $key => $restaurant) {
                $restaurant->logo = Storage::url($restaurant->logo);
                $restaurant->business_licence = Storage::url($restaurant->business_licence);
                $restaurant->vat_certificate = Storage::url($restaurant->vat_certificate);
                $restaurant->bank_statement = Storage::disk('public')->url($restaurant->bank_statement);
                $restaurant->utility_bill = Storage::disk('public')->url($restaurant->utility_bill);
                $restaurant->restaurant_menu = Storage::disk('public')->url($restaurant->restaurant_menu);
            }
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
}
