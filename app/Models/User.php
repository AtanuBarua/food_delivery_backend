<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const USERTYPE_ADMIN = 1;
    const USERTYPE_OWNER = 2;
    const USERTYPE_CUSTOMER = 3;
    const USERTYPE_RIDER = 4;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function createOwner($request) {
        $data = $this->prepareOwnerCreateData($request);
        return self::create($data);
    }

    private function prepareOwnerCreateData($request) {
        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['password'] = Hash::make($request['password']);
        $data['user_type'] = self::USERTYPE_OWNER;
        $data['phone'] = $request['phone'];
        $data['status'] = 0;
        return $data;
    }
}
