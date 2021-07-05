<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;
    protected $table = 'menus';
    public $timestamps = true;

     protected $fillable = [
        'restra_id',
        'category_id',
        'subcategory_id',
        'menu_name',
        'image',
        'price',
        'rating',
        'description',
        'discount',
        'status',
        'foodstatus',
      'chef_special',
      'best_seller',
      'total_amount'
      
    ];
      public function category()
    {
        return $this->belongsTo('App\Models\categories');
    }

     public function subcategory()
    {
        return $this->belongsTo('App\Models\subcategories');
    }
}
