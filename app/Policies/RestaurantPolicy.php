<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RestaurantPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Restaurant $restaurant): Response {
        return $restaurant->owner_id == $user->id ? Response::allow() : Response::denyAsNotFound();
    }
}
