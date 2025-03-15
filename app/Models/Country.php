<?php

namespace App\Models;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['name','iso3','unicodeFlag'];

    public function cities(){
        return $this->hasManyThrough(City::class,State::class); 
    }
    public function states(){
        return $this->hasMany(State::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }
}
