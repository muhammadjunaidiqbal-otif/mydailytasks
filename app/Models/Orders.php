<?php

namespace App\Models;

use App\Models\BillingAddress;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "orders";
    protected $fillable = ['user_id','billing_id','cart','total','discount','status','payment_status'];

    public function billingAddress(){
        return $this->belongsTo(BillingAddress::class,'billing_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
