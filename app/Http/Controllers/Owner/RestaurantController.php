<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function addRestaurant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'logo' => 'sometimes|image|mimes:png,jpg,jpeg|max:2048',
            'address' => 'required',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'business_licence' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'vat_certificate' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'tax_identification_number' => 'required|string|max:20',
            'bank_statement' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'utility_bill' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'restaurant_menu' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $status_code = 500;
        $status_message = 'Something went wrong';

        try {
            $status = (new Restaurant())->store($request->all());
            if ($status) {
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
