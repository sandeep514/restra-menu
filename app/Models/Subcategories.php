<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategories extends Model
{
    use HasFactory;
    protected $table = 'subcategory';
    public $timestamps = true;


      protected $fillable = [
        'restra_id',
        'category_id',
        'dish_subcategory',
        'dish_type',
        'image',
        'status'
    ];
    
    public function category(){

        return $this->belongsTo(Categories::class,'id');

    }

     public function allmenu()
    {
     return $this->hasMany(Menus::class,'subcategory_id')->where('status','1');

    }

    public function getBelongedProduct()
    {
      return $this->hasMany(Menus::class ,'subcategory_id' , 'id' )->where('status','1')->SortBy('price','asc');;
    }
}
