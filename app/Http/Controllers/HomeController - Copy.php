<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Redirect;
use App\Models\Restuarant_list;
use App\Models\User;
use App\Models\{Categories,Subcategories};
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
Use Carbon;


class HomeController extends Controller
{
    
     public function index(Request $request){
      $model=Restuarant_list::find($request->id);
      // dd($model);
      if(is_null($model)){
         return view('errorpage'); 
       }  
       elseif(($model->expiry_date <= Carbon\Carbon::now()->toDateTimeString()) ||($model->status=='0'))
      {
        
         return view('errorpage');
      }
      else{
        $categoried=Categories::with('subcatWithmenu')->where(["restra_id"=>$request->id,"status"=>'1'])->get()->toArray();    

          $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray();
           return view('barcode',compact('model','categories','categoried'));
        }
     } 



     public function filter(Request $request)
    {
      // dd($request->all());
      $model=Restuarant_list::find($request->id);
       if(($model->expiry_date <= Carbon\Carbon::now()->toDateTimeString()) ||($model->status=='0'))
      {
        
         return view('errorpage');
      }
      else{
        $categoried=Categories::with('subcatWithmenu')->where(["restra_id"=>$request->id,"status"=>'1'])->get()->toArray();    
        if(!empty($request->content)  && !empty($request->sort_filter) && !empty($request->food_type_filter)){
            $searchString=$request->content;
             $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
            ->orderBy('category.priority','ASC')
            ->where('dish_category','LIKE','%'.$searchString.'%')
            ->orwhere('dish_category','LIKE','%'.$searchString.'%')
            ->orwhere('menu_name','LIKE','%'.$searchString.'%')
            ->whereIn('menus.foodstatus', $request->food_type_filter)
            ->orderBy('menus.price',$request->sort_filter)
            ->select('category.*', 'subcategory.*', 'menus.*')->get();
             $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray();
        }
        elseif(!empty($request->food_type_filter)){
        
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
             ->orderBy('menus.price',$request->sort_filter)
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->whereIn('menus.foodstatus', $request->food_type_filter)
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }
        elseif(!empty($request->sort_filter)){  
        
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('menus.price',$request->sort_filter)
            // ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
            ->select('category.*', 'subcategory.*', 'menus.*')->get();
             $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray();
            
        }
       elseif(!empty($request->advancefilter) && !empty($request->sort_filter) && !empty($request->food_type_filter)){
        if($request->advancefilter==1){
            
            if((!empty($request->best_seller)) && (!empty($request->chef))&& (!empty($request->subactegory_filter))&& (!empty($request->food_type))){
               // echo "2";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->whereIn('menus.foodstatus', $request->food_type)
            ->where('menus.best_seller','1')
            ->where('menus.chef_special','1')
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }
            elseif((!empty($request->best_seller)) && (!empty($request->chef))){
               // echo "1";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
            ->where('menus.best_seller','1')
            ->where('menus.chef_special','1')
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }
            elseif((!empty($request->subactegory_filter))&& (!empty($request->food_type))){
               // echo "3";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
            ->whereIn('menus.foodstatus', $request->food_type)
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->select('category.*','subcategory.*','menus.*')->groupBy()->get();
            // dd($get);
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
               // dd($categories);
            }
            elseif(!empty($request->chef) && (!empty($request->subactegory_filter))){
               // echo "4";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->orderBy('category.priority','ASC')
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->where('menus.chef_special','1')
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }

            elseif(!empty($request->chef) && (!empty($request->food_type))){
               // echo "5";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->orderBy('category.priority','ASC')
            ->where('menus.chef_special','1')
            ->whereIn('menus.foodstatus', $request->food_type)
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }

             elseif((!empty($request->food_type)) && (!empty($request->chef)) && (!empty($request->best_seller))){
               // echo "6";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->orderBy('category.priority','ASC')
            // ->where(['best_seller'=>'1','chef_special'=>'1'])
            ->where('menus.best_seller','1')
            ->where('menus.chef_special','1')
            ->whereIn('menus.foodstatus',  $request->food_type)
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }
            elseif(!empty($request->best_seller) && (!empty($request->food_type))){
               // echo "7";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->orderBy('category.priority','ASC')
            ->where('menus.best_seller','1')
            ->whereIn('menus.foodstatus', $request->food_type)
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }

            elseif(!empty($request->best_seller) && (!empty($request->subactegory_filter))){
               // echo "8";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->orderBy('category.priority','ASC')
            ->where('menus.best_seller','1')
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }

            elseif(!empty($request->chef)){
               // echo "9";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where('menus.chef_special','1')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }
            elseif(!empty($request->food_type)){
               // echo "10";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->whereIn('menus.foodstatus', $request->food_type)
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }
            
            elseif(!empty($request->subactegory_filter)){
               // echo "11";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->whereIn('category.id', $request->subactegory_filter)
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
            // dd($get);
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }

             elseif(!empty($request->best_seller)){
               // echo "12";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])            
            ->orderBy('category.priority','ASC')
            ->where('menus.best_seller','1')
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray(); 
            }
        }
        else{
         // echo "13";
            $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray();
        } }
        else{

          $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray();
               // dd($categories);
        }
        if(!empty($categories)){
           $response['html']=View('layouts.filter',compact('model','categories','categoried'))->render();
        }
        else{
           $get=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->orderBy('category.priority','ASC')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
            ->select('category.*', 'subcategory.*', 'menus.*')->groupBy()->get();
               $categories=$get->groupBy(['dish_category', 'dish_subcategory'])->toArray();
               $response['html']=View('layouts.filter',compact('model','categories','categoried'))->render();
        }
           return response()->json($response);
         // dd($request);
        }
     } 

     public function demo(Request $request)
    {
          $orders = Categories::with(['subcat'=>function($model){
            return $model->with(['allmenu'])->groupBy('dish_subcategory');
            }])->where(["restra_id"=>$request->id,"status"=>'1'])->get();
         $categories=$orders->groupBy(['dish_category'])->toArray();
        dd($categories);
    }





   
}
