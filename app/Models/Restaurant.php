<?php

namespace App\Models;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Restaurant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function store($request)
    {
        $data = $this->prepareStoreData($request);
        return self::create($data);
    }

    public function prepareStoreData($request)
    {
        if (!empty($request['logo'])) {
            $request['logo'] = $request['logo']->store('owner');
        }

        if (!empty($request['business_licence'])) {
            $request['business_licence'] = $request['business_licence']->store('owner');
        }

        if (!empty($request['vat_certificate'])) {
            $request['vat_certificate'] = $request['vat_certificate']->store('owner');
        }

        if (!empty($request['bank_statement'])) {
            $request['bank_statement'] = $request['bank_statement']->store('owner');
        }

        if (!empty($request['utility_bill'])) {
            $request['utility_bill'] = $request['utility_bill']->store('owner');
        }

        if (!empty($request['restaurant_menu'])) {
            $request['restaurant_menu'] = $request['restaurant_menu']->store('owner');
        }

        $request['owner_id'] = auth()->id();

        return $request;
    }

    private function prepareUpdateData($request, $restaurant) {
        if (!empty($request['logo'])) {
            if (!empty($restaurant->logo)) {
                Storage::delete($restaurant->logo);
            }
            $request['logo'] = $request['logo']->store('owner');
        }

        if (!empty($request['business_licence'])) {
            if (!empty($restaurant->business_licence)) {
                Storage::delete($restaurant->business_licence);
            }
            $request['business_licence'] = $request['business_licence']->store('owner');
        }

        if (!empty($request['vat_certificate'])) {
            if (!empty($restaurant->vat_certificate)) {
                Storage::delete($restaurant->vat_certificate);
            }
            $request['vat_certificate'] = $request['vat_certificate']->store('owner');
        }

        if (!empty($request['bank_statement'])) {
            if (!empty($restaurant->bank_statement)) {
                Storage::delete($restaurant->bank_statement);
            }

            $request['bank_statement'] = $request['bank_statement']->store('owner');
        }

        if (!empty($request['utility_bill'])) {
            if (!empty($restaurant->utility_bill)) {
                Storage::delete($restaurant->utility_bill);
            }
            $request['utility_bill'] = $request['utility_bill']->store('owner');
        }

        if (!empty($request['restaurant_menu'])) {
            if (!empty($restaurant->restaurant_menu)) {
                Storage::delete($restaurant->restaurant_menu);
            }
            $request['restaurant_menu'] = $request['restaurant_menu']->store('owner');
        }
        
        return $request;
    }

    public function getRestaurantsByOwnerId($owner_id) {
        return self::query()->where('owner_id', $owner_id)->get();
    }

    public function findRestaurantById($id) {
        return self::find($id);
    }

    public function updateRestaurant($request, $restaurantObj) {
        $data = $this->prepareUpdateData($request, $restaurantObj);
        return $restaurantObj->update($data);
    }
}
