<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Restuarant_list,User};
use App\Models\{Categories,SubCategories,Menus};
use Illuminate\Validation\Rule;

class Menu extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
  
      public function menuAdd()
    {
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $data['categories'] = Categories::has('subcat')->where('status','1')->where('restra_id',$id)->get();
        return view('manager.menu.create',$data);
    }

    public function fetchsubcategory(Request $request)
    {
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $data['Subcategories'] = SubCategories::where(["category_id"=>$request->category_id,"status"=>'1',"restra_id"=>$id])->get(["dish_subcategory", "id"]);
        return response()->json($data);
    }
  
    public function menuStore(Request $request)
    {
       
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $request->validate([
            'dish_category' => 'required',
            'dish_subcategory' => 'required',
            'menu_name.*' => 'required|max:150',
            'price.*' => 'required|integer',
            'discount.*'=>'integer',
            'description.*'=>'required|max:500',
            'rating.*'=>'required',
            'menu_image.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foodstatus.*'=>'required',

        ]);
        for($count=0;$count<count($request['menu_name']);$count++)
           {
                 if(!empty($request['discount'][$count]))
                    {
                        if($request['price'][$count] <= $request['discount'][$count]){                
                        return redirect()->back()
                        ->withErrors('Discount amount is more than actual price');    
                        }            
                    } 
                    else{                 
                $name = $request->file('menu_image')[$count]->getClientOriginalName();
                $destinationPath = public_path('category/');
                $request->file('menu_image')[$count]->move($destinationPath, $name);
               if(is_null($request['discount'][$count])){                
                $discount='0';
                $total_amount=$request['price'][$count];
               }
               else{                
                $discount=$request['discount'][$count]; 
                $total_amount=$request['price'][$count] - $request['discount'][$count];              
               }
            $data=array(
                'restra_id'=>$id,
                'category_id'=>$request['dish_category'],
                'subcategory_id'=>$request['dish_subcategory'],
                'menu_name'=>$request['menu_name'][$count],
                'price'=>$request['price'][$count],
                'description'=>$request['description'][$count],
                'rating'=>$request['rating'][$count],
                'image'=>$name,
                'foodstatus'=>$request['foodstatus'][$count],
                'discount'=>$discount,
                'total_amount'=>$total_amount
            );
           
            Menus::create($data);
        }
          }
        return redirect()->back()
            ->with('success', 'created successfully.');
    }

    public function menudestroy($id)
    {
        $detail = Menus::find($id);
        $detail->delete();
        return redirect()->back()->with('success', 'Menu deleted');
    }

    public function menustatus($id, $status)
    {   
        if($status== '1' ){
            $status = '0';
        }else{
            $status = '1';
        }
        $detail = Menus::where('id', $id)->update(['status' => $status]);
        return redirect()->back()->with('success', 'Status changed');
    }


   public function foodstatus($id, $status)
    {   
        if($status== '1' ){
            $status = '2';
        }else{
            $status = '1';
        }
        $detail = Menus::where('id', $id)->update(['foodstatus' => $status]);
        return redirect()->back()->with('success', 'Status changed');
    }

public function specialstatus($id, $status)
    {   
        if($status== '1' ){
            $status = '0';
        }else{
            $status = '1';
        }
        $detail = Menus::where('id', $id)->update(['chef_special' => $status]);
        return redirect()->back()->with('success', 'Status changed');
    }

    public function sellerstatus($id, $status)
    {   
        if($status== '1' ){
            $status = '0';
        }else{
            $status = '1';
        }
        $detail = Menus::where('id', $id)->update(['best_seller' => $status]);
        return redirect()->back()->with('success', 'Status changed');
    }

    public function menuEdit($id)
    {
        $log_id=auth()->user()->id;
        $ids=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $detail = Menus::find($id);
        $categories =Categories::has('subcat')->where('status','1')->where('restra_id',$ids)->get();
        $subcategories = SubCategories::where('status','1')->where('restra_id',$ids)->get(["dish_subcategory", "id"]);
        return view('manager.menu.edit', compact('detail','categories','subcategories'));
    }

    public function editmenu(Request $request, $id)
    { 
        // dd($request);
        $menu = Menus::findOrFail($id);
        $log_id=auth()->user()->id;
        $ids=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $request->validate([
            'dish_category' => 'required',
            'dish_subcategory' => 'required',
            'menu_name' => ['max:150', Rule::unique('menus', 'menu_name')->where('restra_id',$ids)->where('category_id',$menu['category_id'])->where('subcategory_id',$menu['subcategory_id'])->ignore($id)],
            'price' => 'required|integer',
            'discount'=>'integer',
            'description'=>'required|max:500',
            'rating'=>'required',
            'foodstatus'=>'required'

            // 'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        if(!empty($request->discount))
        {
            if($menu->price <= $request->discount){                
            return redirect()->back()
            ->withErrors('Discount amount is more than actual price');    
            }            
        }    
        if ($request->file('image'))
        {
            $name = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('category/');
            $request->file('image')->move($destinationPath,$name);
        }
        
        if ($request->hasFile('image'))
        {
            $menu->image = $name;
        }
        $menu->update($request->except(['image']));

        return redirect()
            ->route('menu.view')
            ->with('success', 'updated');
    }

    public function menuView()
    {
        
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $model=Menus::orderBy('id','asc')->where('restra_id',$id)->get();
        return view('manager.menu.view',['model'=>$model]);
    }
}