<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'users';
    public $timestamps = true;

    protected $fillable = ['role_id','name','email','password','mobile','address','proof','police_verify','join_date','leave_date','reason','salary','status','parent_id'];

     protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function attend()
    {
        return $this->hasOne(Attendance::class,'employ_id')->orderBy('attend_date','DESC');
    }

        public function atend_all()
    {
        return $this->hasMany(Attendance::class,'employ_id')->orderBy('attend_date','ASC');
    }

    
}
