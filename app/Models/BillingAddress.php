<?php

namespace App\Models;

use App\Models\City;
use App\Models\State;
use App\Models\Orders;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    protected $table = 'billing_address';
    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'postal_code',
        'phone',
        'email',
        'description',
        'created_at',
        'updated_at'
     ];
     public $timestamps = false;
    //protected $guarded = ['id'];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function orders()
    {
        return $this->hasMany(Orders::class, 'billing_id');
    }
}
