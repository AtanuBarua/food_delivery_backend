<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class RestaurantCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($restaurant) {
            return [
                'id' => $restaurant->id,
                'name' => $restaurant->name,
                'logo' => $this->formatFileUrl($restaurant->logo),
                'address' => $restaurant->address,
                'owner_id' => $restaurant->owner_id,
                'business_licence' => $this->formatFileUrl($restaurant->business_licence),
                'vat_certificate' => $this->formatFileUrl($restaurant->vat_certificate),
                'tax_identification_number' => $restaurant->tax_identification_number,
                'bank_statement' => $this->formatFileUrl($restaurant->bank_statement),
                'utility_bill' => $this->formatFileUrl($restaurant->utility_bill),
                'restaurant_menu' => $this->formatFileUrl($restaurant->restaurant_menu),
                'status' => $restaurant->status,
            ];
        })->all();
    }

    private function formatFileUrl($path)
    {
        return $path ? Storage::url($path) : null;
    }
}
