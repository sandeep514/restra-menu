<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableBooking extends Model
{
    use HasFactory;
     protected $table = 'table_booking';
    public $timestamps = true;

     protected $fillable = [
        'capacity',
        'status',
        'booking_status',
        'table_number',
        'restra_id',
        'status',
        'priority',
        'qrcode'
    ];

}
 