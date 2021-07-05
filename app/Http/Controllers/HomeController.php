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
      // DB::enableQueryLog();
      // dd($request);
      $model=Restuarant_list::find($request->id);
       if(($model->expiry_date <= Carbon\Carbon::now()->toDateTimeString()) ||($model->status=='0'))
      {
        
         return view('errorpage');
      }
      else{
             $categoried=Categories::with('subcatWithmenu')->where(["restra_id"=>$request->id,"status"=>'1'])->get()->toArray();    
             $table_join=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->select('category.*', 'subcategory.*', 'menus.*')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1']);
               // ->orderBy('category.priority','ASC');

           
            if(!empty($request->food_type_filter) && !empty($request->sort_filter )){         
            $query=$table_join
            ->whereIn('menus.foodstatus', $request->food_type_filter)
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

          

            if(!empty($request->food_type_filter)&& !empty($request->sort_filter)&& !empty($request->content) &&!empty($request->subactegory_filter)){
            $type=$request->content;
             // DB::connection()->enableQueryLog();  
            $query=$table_join
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->whereIn('menus.foodstatus', $request->food_type_filter)
            ->where(function($query) use ($type){
                  $query->where('category.dish_category','LIKE','%'.$type.'%')
                ->orwhere('subcategory.dish_subcategory','LIKE','%'.$type.'%')
                ->orwhere('menus.menu_name','LIKE','%'.$type.'%');
            })            
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->content ) && !empty($request->sort_filter )){         
             $type=$request->content;  
               // DB::connection()->enableQueryLog();  
            $query=$table_join
            ->where(function($query) use ($type){
                  $query->where('category.dish_category','LIKE','%'.$type.'%')
                ->orwhere('subcategory.dish_subcategory','LIKE','%'.$type.'%')
                ->orwhere('menus.menu_name','LIKE','%'.$type.'%');
            })
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            //  $queries = DB::getQueryLog();
            // dd($queries);
            }

            // if(!empty($request->food_type_filter) && !empty($request->content)){         
            //  $type=$request->content;  
            // $query=$table_join
            // ->whereIn('menus.foodstatus', $request->food_type_filter)->where(function($query) use ($type){
            //       $query->where('category.dish_category','LIKE','%'.$type.'%')
            //     ->orwhere('subcategory.dish_subcategory','LIKE','%'.$type.'%')
            //     ->orwhere('menus.menu_name','LIKE','%'.$type.'%');
            // })->get();                         
            // }
            
            if(!empty($request->sort_filter))
            {
              $query=$table_join->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->food_type_filter))
            {
              $query=$table_join->whereIn('menus.foodstatus', $request->food_type_filter)
               ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

  
           
           // // Advance filters
           if((!empty($request->best_seller)) && (!empty($request->chef))&& (!empty($request->subactegory_filter))&& (!empty($request->food_type))){
            $query=$table_join->whereIn('menus.category_id', $request->subactegory_filter)
            ->whereIn('menus.foodstatus', $request->food_type)
            ->where('menus.best_seller','1')
            ->where('menus.chef_special','1')
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->best_seller) && !empty($request->chef)&& !empty($request->subactegory_filter)&& !empty($request->food_type) && !empty($request->content) && !empty($request->sort_filter)){
            $type=$request->content;  
            $query=$table_join->whereIn('menus.category_id', $request->subactegory_filter)
            ->whereIn('menus.foodstatus', $request->food_type)
            ->where('menus.best_seller','1')
            ->where('menus.chef_special','1')
            ->where(function($query) use ($type){
                  $query->where('category.dish_category','LIKE','%'.$type.'%')
                ->orwhere('subcategory.dish_subcategory','LIKE','%'.$type.'%')
                ->orwhere('menus.menu_name','LIKE','%'.$type.'%');
            })->get();                         
            }

            if(!empty($request->subactegory_filter)&& !empty($request->food_type) && !empty($request->best_seller)&& !empty($request->sort_filter)){
            $query=$table_join->whereIn('menus.foodstatus', $request->food_type)
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->where('menus.best_seller','1')
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }



            // if(!empty($request->subactegory_filter)&& !empty($request->food_type_filter)&& !empty($request->sort_filter)){
                 
            // $query=$table_join->whereIn('menus.foodstatus', $request->food_type_filter)
            // ->whereIn('menus.category_id', $request->subactegory_filter)
            // ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            
            // }

           

             if(!empty($request->food_type_filter) && !empty($request->content ) && !empty($request->sort_filter )){  
              $type=$request->content;
           
       
            $query=$table_join
             ->whereIn('menus.foodstatus', $request->food_type_filter)
            ->where(function($query) use ($type){
                  $query->where('category.dish_category','LIKE','%'.$type.'%')
                ->orwhere('subcategory.dish_subcategory','LIKE','%'.$type.'%')
                ->orwhere('menus.menu_name','LIKE','%'.$type.'%');
            })
            ->orderBy('menus.total_amount',$request->sort_filter)->get(); 
            // $queries = DB::getQueryLog();
            // dd($queries);
            } 

            if(!empty($request->subactegory_filter)&& !empty($request->food_type_filter) && !empty($request->chef) && !empty($request->sort_filter)){
            $query=$table_join->whereIn('menus.foodstatus', $request->food_type_filter)
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->where('menus.chef_special','1')
            ->orderBy('menus.total_amount',$request->sort_filter)->get(); 
            }

            if(!empty($request->subactegory_filter)&& !empty($request->food_type) && !empty($request->chef)&& !empty($request->sort_filter)){
            $query=$table_join->whereIn('menus.foodstatus', $request->food_type)
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->where('menus.chef_special','1')
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

             if(!empty($request->subactegory_filter)&& !empty($request->food_type_filter) && !empty($request->chef) && !empty($request->sort_filter)&& !empty($request->content )){
                $type=$request->content;
            $query=$table_join->whereIn('menus.foodstatus', $request->food_type_filter)
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->where('menus.chef_special','1')
            ->orderBy('menus.total_amount',$request->sort_filter)
            ->where(function($query) use ($type){
                  $query->where('category.dish_category','LIKE','%'.$type.'%')
                ->orwhere('subcategory.dish_subcategory','LIKE','%'.$type.'%')
                ->orwhere('menus.menu_name','LIKE','%'.$type.'%');
            })
            ->orderBy('menus.total_amount',$request->sort_filter)->get(); 
            }

            if(!empty($request->subactegory_filter)&& !empty($request->food_type) && !empty($request->chef)&& !empty($request->sort_filter)&& !empty($request->content )){
                $type=$request->content;
            $query=$table_join->whereIn('menus.foodstatus', $request->food_type)
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->where('menus.chef_special','1')
            ->orderBy('menus.total_amount',$request->sort_filter)
            ->where(function($query) use ($type){
                  $query->where('category.dish_category','LIKE','%'.$type.'%')
                ->orwhere('subcategory.dish_subcategory','LIKE','%'.$type.'%')
                ->orwhere('menus.menu_name','LIKE','%'.$type.'%');
            })
            ->orderBy('menus.total_amount',$request->sort_filter)->get(); 
            }

            if(!empty($request->subactegory_filter)&& !empty($request->chef) && !empty($request->best_seller)&& !empty($request->sort_filter)){
            $query=$table_join->whereIn('menus.category_id', $request->subactegory_filter)
            ->where('menus.chef_special','1')
            ->where('menus.best_seller','1')
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

             if(!empty($request->subactegory_filter)&& !empty($request->chef) && !empty($request->best_seller)&& !empty($request->sort_filter)&& !empty($request->content )){
                $type=$request->content;
            $query=$table_join->whereIn('menus.category_id', $request->subactegory_filter)
            ->where('menus.chef_special','1')
            ->where('menus.best_seller','1')
            ->orderBy('menus.total_amount',$request->sort_filter)
            ->where(function($query) use ($type){
                  $query->where('category.dish_category','LIKE','%'.$type.'%')
                ->orwhere('subcategory.dish_subcategory','LIKE','%'.$type.'%')
                ->orwhere('menus.menu_name','LIKE','%'.$type.'%');
            })
            ->orderBy('menus.total_amount',$request->sort_filter)->get(); 
            }

            if(!empty($request->food_type)&& !empty($request->chef) && !empty($request->best_seller)&& !empty($request->sort_filter)&& !empty($request->content )){
                $type=$request->content;
            $query=$table_join->whereIn('menus.foodstatus', $request->food_type)
            ->where('menus.chef_special','1')
            ->where('menus.best_seller','1')
            ->orderBy('menus.total_amount',$request->sort_filter)
            ->where(function($query) use ($type){
                  $query->where('category.dish_category','LIKE','%'.$type.'%')
                ->orwhere('subcategory.dish_subcategory','LIKE','%'.$type.'%')
                ->orwhere('menus.menu_name','LIKE','%'.$type.'%');
            })
            ->orderBy('menus.total_amount',$request->sort_filter)->get(); 
            }


            if(!empty($request->subactegory_filter)&& !empty($request->food_type)&& !empty($request->sort_filter)){
            $query=$table_join->whereIn('menus.foodstatus', $request->food_type)
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->best_seller) && !empty($request->subactegory_filter)&& !empty($request->sort_filter)){
            $query=$table_join->whereIn('menus.category_id', $request->subactegory_filter)
            ->where('menus.best_seller','1')
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->best_seller) && !empty($request->food_type)&& !empty($request->sort_filter)){
            $query=$table_join->where('menus.best_seller','1')
            ->whereIn('menus.foodstatus', $request->food_type)
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->chef) && !empty($request->subactegory_filter)&& !empty($request->sort_filter)){
            $query=$table_join->where('menus.chef_special','1')
            ->whereIn('menus.category_id', $request->subactegory_filter)
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->chef) && !empty($request->food_type)&& !empty($request->sort_filter)){
            $query=$table_join->where('menus.chef_special','1')
            ->whereIn('menus.foodstatus', $request->food_type)
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->best_seller) && !empty($request->chef)&& !empty($request->sort_filter)){
            $query=$table_join->where('menus.best_seller','1')
            ->where('menus.chef_special','1')
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->best_seller)&& !empty($request->sort_filter)){
            $query=$table_join->where('menus.best_seller','1')
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }

            if(!empty($request->chef)&& !empty($request->sort_filter)){
            $query=$table_join->where('menus.chef_special','1')
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }
             if(!empty($request->food_type)&& !empty($request->sort_filter)){
            $query=$table_join->whereIn('menus.foodstatus', $request->food_type)
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }
            if(!empty($request->subactegory_filter)&& !empty($request->sort_filter)){
            $query=$table_join->whereIn('menus.category_id', $request->subactegory_filter)
            ->orderBy('menus.total_amount',$request->sort_filter)->get();                         
            }




            // 
            
            $categories=$query->groupBy(['dish_category', 'dish_subcategory'])->toArray();
             // $queries = \DB::getQueryLog();
             // dd($queries);
            if(!empty($categories)){
                $response['html']=View('layouts.filter',compact('model','categories','categoried'))->render();
            }
            else{
             $table_join=DB::table('category')
            ->join('subcategory', 'category.id', '=', 'subcategory.category_id')
            ->join('menus', 'subcategory.id','=','menus.subcategory_id')
            ->select('category.*', 'subcategory.*', 'menus.*')
            ->where(["category.restra_id"=>$request->id,"category.status"=>'1'])
             ->orderBy('menus.total_amount',$request->sort_filter)->get();
              $categories= $table_join->groupBy(['dish_category', 'dish_subcategory'])->toArray();                
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
