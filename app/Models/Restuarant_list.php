<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restuarant_list extends Model
{
    use HasFactory;

    protected $table = 'restuarant_list';
    public $timestamps = true;

     protected $fillable = [
        'user_id',
        'name',
        'location',
        'contact',
        'description',
        'country',
        'state',
        'city',
        'logo',
        'email',
        'status',
        'created_at',
        'expiry_date'
    ];
}
