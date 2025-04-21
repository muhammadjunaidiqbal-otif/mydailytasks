<?php

namespace App\Models;

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

}
