<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class Roles extends Controller
{
     public function index()
    {
        $model=Role::orderBy('id','asc')->get();

        return view('admin.role.index',['model'=>$model]);
    }

    public function roleAdd()
    {
        return view('admin.role.create');
    }

    public function roleStore(Request $request)
    {
       
        $request->validate(['name' => 'required|unique:roles']);
        Role::create($request->all());
        return redirect()->back()
            ->with('success', 'created successfully.');
    }

    public function roledestroy($id)
    {
        $detail = Role::find($id);
        $detail->delete();
        return redirect()->back()->with('success', 'Role deleted');
    }

    public function rolestatus($id, $status)
    {   
        if($status== '1' ){
            $status = '0';
        }else{
            $status = '1';
        }
        $detail = Role::where('id', $id)->update(['status' => $status]);
        return redirect()->back()->with('success', 'Status changed');
    }

    public function roleEdit($id)
    {
        $detail = Role::find($id);
        return view('admin.role.edit', compact('detail'));
    }

    public function editrole(Request $request, $id)
    { 

        $role = Role::findOrFail($id);
       $test= $request->validate([
        'name' => 'required|unique:roles,name,'. $id.',id',
    ]);
        $role->update($request->all());

        return redirect()
            ->route('admin.role')
            ->with('success', 'updated');
    }

}
