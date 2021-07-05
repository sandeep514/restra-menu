<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;


    public function states()
    {
        return $this->hasMany('App\Models\State');
    }

     public function cities()
    {
        return $this->hasMany('App\Models\City');
    }

     public function states_id()
    {
       return $this->hasMany(State::class,'country_id');
    }

     public function cities_id()
    {
        return $this->hasMany(City::class,'state_id');
    }
}
