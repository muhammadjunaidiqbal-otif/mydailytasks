<?php

namespace App\Models;

use App\Models\User;
use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = ['name','state_id','country_id'];

    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function state(){
        return $this->belongsTo(State::class);
    }


    public function users(){
        return $this->hasMany(User::class);
    }

}
