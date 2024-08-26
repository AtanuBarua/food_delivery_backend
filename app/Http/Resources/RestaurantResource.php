<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->formatFileUrl($this->logo),
            'address' => $this->address,
            'owner_id' => $this->owner_id,
            'business_licence' => $this->formatFileUrl($this->business_licence),
            'vat_certificate' => $this->formatFileUrl($this->vat_certificate),
            'tax_identification_number' => $this->tax_identification_number,
            'bank_statement' => $this->formatFileUrl($this->bank_statement),
            'utility_bill' => $this->formatFileUrl($this->utility_bill),
            'restaurant_menu' => $this->formatFileUrl($this->restaurant_menu),
            'status' => $this->status,
        ];
    }

    private function formatFileUrl($path) {
        return $path ? Storage::url($path) : null;
    }
}
