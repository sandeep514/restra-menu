<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Restuarant_list,User,Categories};
use App\Models\SubCategories;
use Illuminate\Validation\Rule;

class Subcategory extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */ public function SubcategoryAdd()
    {
        $log_id=auth()->user()->id;
       $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $data['categories'] = Categories::where('status','1')->where('restra_id',$id)->get(["dish_category", "id"]);
        return view('manager.Subcategory.create',$data);
    }


    public function SubCategoryStore(Request $request)
    {
        // dd($request);
         $request->validate([
            'category_id' => 'required',
            'dish_type' => 'required|array',
            'dish_subcategory' => 'required|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $detail = SubCategories::where('restra_id', $id)->where('category_id',$request['category_id'])->where('dish_subcategory',$request['dish_subcategory'])->get();
        if(count($detail)>2){
            return redirect()->back()
            ->withErrors('Already exists');    
        }
        else{  
         if ($request->file('image'))
        {
             $name = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('category/');
            $request->image->move($destinationPath, $name);
        }      
         foreach ($request->dish_type as $k => $v) {
            SubCategories::create(['restra_id'=>$id,'dish_type' => $v, 'dish_subcategory' => $request->dish_subcategory ,'category_id'=>$request->category_id,'image'=>$name]);
        }
        return redirect()->back()
            ->with('success', 'created successfully.');
    }}

    public function subcategorydestroy($id)
    {
        $detail = SubCategories::find($id);
        $detail->delete();
        return redirect()->back()->with('success', 'subCategory deleted');
    }

    public function subcategorystatus($id, $status)
    {   
        if($status== '1' ){
            $status = '0';
        }else{
            $status = '1';
        }
        $detail = SubCategories::where('id', $id)->update(['status' => $status]);
        return redirect()->back()->with('success', 'Status changed');
    }

    public function subcategoryEdit($id)
    {
        $detail = SubCategories::find($id);
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $categories= Categories::where('status','1')->where('restra_id',$id)->get(["dish_category", "id"]);
        return view('manager.Subcategory.edit', compact('detail','categories'));
    }

    public function subeditcategory(Request $request, $id)
    { 
        $subcategory = SubCategories::findOrFail($id);
        $log_id=auth()->user()->id;
        $ids=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $request->validate([
            // 'dish_subcategory' =>  ['max:100', Rule::unique('subcategory', 'dish_subcategory')->where('restra_id',$ids)->where('category_id',$subcategory['category_id'])->ignore($id)],
            'dish_subcategory' =>  'max:100',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
         if ($request->file('image'))
        {
            $name = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('category/');
            $request->file('image')->move($destinationPath,$name);
        }        
        if ($request->hasFile('image'))
        {
            $subcategory->image = $name;
        }

              $subcategory->update($request->except(['image']));

        return redirect()
            ->route('menu.subcategoryview')
            ->with('success', 'updated');
    }

    public function SubcategoryView()
    {
         $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
         $model=SubCategories::orderBy('id','asc')->where('restra_id',$id)->get();
        return view('manager.Subcategory.view',['model'=>$model]);
    }
}