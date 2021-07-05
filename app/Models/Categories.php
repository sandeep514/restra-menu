<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
     use HasFactory;

   // public static $cattype = [1 => 'Veg' , 2 => 'Nonveg' ];
    protected $table = 'category';
    public $timestamps = true;

     protected $fillable = [
        'restra_id',
        'dish_category',
        'image',
        'status',
        'priority'
    ];


    // public static function getType($selectedtype)
    // {
    //     return self::$cattype[$selectedtype];
    // } 
    public function subcat()
    {
     return $this->hasMany(SubCategories::class,'category_id')->where('status','1');
    }
   
    public static function getActiveCategory()
    {
        return Self::where('status', 1)->pluck('dish_category', 'id')->prepend('Please select category');
    }
    
    public function subcatWithmenu(){
     return $this->subcat()->with('allmenu');
}
}
			
