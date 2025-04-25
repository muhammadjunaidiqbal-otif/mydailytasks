<?php

namespace App\Models;

use App\Models\City;
use App\Models\Role;
use App\Models\State;
use App\Models\Country;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable ,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */




     
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'password',
        'email_verified_at',
        'country_id',
        'state_id',
        'city_id'
    ];
  

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isEmailVerified(): bool
    {
    return $this->hasVerifiedEmail();
    }
    public function country(){
        return $this->belongsTo(Country::class);     
    }
    public function state(){
        return $this->belongsTo(State::class);     
    }
    public function city(){
        return $this->belongsTo(City::class);     
    }
    public function role(){
        return $this->belongsTo(Role::class);     
    }

}
