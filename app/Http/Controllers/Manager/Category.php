<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Restuarant_list;
 use Illuminate\Validation\Rule;

class Category extends Controller
{ 
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function CategoryAdd()
    {
        return view('manager.category.create');
    }

    public function CategoryStore(Request $request)
    {   

        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $detail = Categories::where('restra_id', $id)->where('dish_category',$request['dish_category'])->get();
        if(count($detail)>0)
        {
            return redirect()->back()
            ->withErrors('Already exists');    
        }else{
        $request->validate([
            'dish_category' =>  'required|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'priority'=>'required'
        ]);
        
        
        if ($request->file('image'))
        {
             $name = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('category/');
            $request->image->move($destinationPath, $name);
        } 
        //

        $input = $request->all();
        $input['restra_id']=$id;
        $input['image'] = $name;
        
        $chk = Categories::create($input);
        return redirect()->back()
            ->with('success', 'created successfully.');
        }    
    }

    public function categorydestroy($id)
    {
        $detail = Categories::find($id);
        $detail->delete();
        return redirect()->back()->with('success', 'Category deleted');
    }

    public function categorystatus($id, $status)
    {   
        if($status== '1' ){
            $status = '0';
        }else{  
            $status = '1';
        }
        $detail = Categories::where('id', $id)->update(['status' => $status]);
        return redirect()->back()->with('success', 'Status changed');
    }

    public function categoryEdit($id)
    {
        $detail = Categories::find($id);
        return view('manager.category.edit', compact('detail'));
    }

    public function editcategory(Request $request, $id)
    { 
        $log_id=auth()->user()->id;
        $ids=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $request->validate([
            'dish_category' =>  ['max:100', Rule::unique('category', 'dish_category')->where('restra_id',$ids)->ignore($id)],
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'priority'=>'required'
        ]);
        if ($request->file('image'))
        {
            $name = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('category/');
            $request->file('image')->move($destinationPath,$name);
        }
        $category = Categories::findOrFail($id);
        if ($request->hasFile('image'))
        {
            $category->image = $name;
        }
        $category->update($request->except(['image']));

        return redirect()
            ->route('menu.categoryview')
            ->with('success', 'updated');
    }

    public function CategoryView()
    {

        // dd(auth()->user()->role_id);
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $model = Categories::orderBy('priority', 'asc')->where('restra_id',$id)->get();
        return view('manager.category.view', ['model' => $model]);
    }

    public function updatesort(Request $request)
    {
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $tasks = Categories::where('restra_id', $id)->get();

        foreach ($tasks as $task) {
            $task->timestamps = false; // To disable update_at field updation
            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['priority' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    }
}
