<?php

namespace App\Models;

use App\Models\City;
use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    protected $fillable = ['name','country_id','state_code'];
   

    public function cities(){
        return $this->hasMany(City::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);     
    }
    public function users(){
        return $this->hasMany(User::class);
    }
}
