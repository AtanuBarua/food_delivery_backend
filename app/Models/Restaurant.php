<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            $logoPath = $request['logo']->store('owner');
        }

        if (!empty($request['business_licence'])) {
            $businessLicencePath = $request['business_licence']->store('owner');
        }

        if (!empty($request['vat_certificate'])) {
            $vatCertificatePath = $request['vat_certificate']->store('owner');
        }

        if (!empty($request['bank_statement'])) {
            $bankStatementPath = $request['bank_statement']->store('owner');
        }

        if (!empty($request['utility_bill'])) {
            $utilityBillPath = $request['utility_bill']->store('owner');
        }

        if (!empty($request['restaurant_menu'])) {
            $restaurantMenuPath = $request['restaurant_menu']->store('owner');
        }

        $data = [];
        $data['name'] = $request['name'];
        $data['logo'] = $logoPath;
        $data['address'] = $request['address'];
        $data['owner_id'] = auth()->id();
        $data['business_licence'] = $businessLicencePath;
        $data['vat_certificate'] = $vatCertificatePath;
        $data['tax_identification_number'] = $request['tax_identification_number'];
        $data['bank_statement'] = $bankStatementPath;
        $data['utility_bill'] = $utilityBillPath;
        $data['restaurant_menu'] = $restaurantMenuPath;

        return $data;
    }

    public function getRestaurantsByOwnerId($owner_id) {
        return self::query()->where('owner_id', $owner_id)->get();
    }

    public function findRestaurantById($id) {
        return self::find($id);
    }
}
