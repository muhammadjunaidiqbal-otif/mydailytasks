<?php

namespace App\Models;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['name'];

    public function cities(){
        return $this->hasManyThrough(City::class,State::class); 
    }
}
