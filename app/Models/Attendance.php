<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendance';
    public $timestamps = true;

    protected $fillable = [
        'employ_id',
        'attend_date',
        'time_start',
        'time_end',
        'punch',
        'duration',
        'attend_month',
        'attend_year',
    ];
    public function employ()
    {
        return $this->belongsTo(Employee::class, 'id');
    }

   
}
