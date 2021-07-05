<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Restuarant_list;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Employees extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }

    public function employeeAdd()
    {
        $data['role']=Role::where('id','>','2')->get();
        return view('manager.employee.create',$data);
    }

     protected function validateEmployeeRequest($request, $from = 'create'){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => 'required|unique:users|max:10|',
            'address' => 'required',
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'police_verify'=>'required',
            'join_date'=>'required',
            'salary'=>'required',
           ];
        if($from == 'create'){
            $rules['password'] = ['required', 'string', 'min:8'];
        }

        $this->validate($request,$rules);
    }
    public function employeeStore(Request $request)
    {
	    $this->validateEmployeeRequest($request);
	    $input=$request->all();
	    $log_id=auth()->user()->id;
        $parent=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $input['parent_id']=$parent;
	    $input['password']= Hash::make($request['password']);
	    if ($request->file('proof'))
        {
             $name = $request->file('proof')->getClientOriginalName();
            $destinationPath = public_path('proof/');
            $request->proof->move($destinationPath, $name);
        } 
        $input['proof'] = $name;
        $chk = Employee::create($input);
        return redirect()->back()
            ->with('success', 'created successfully.');
    }

    public function employeedestroy($id)
    {
        $detail = Employee::find($id);
        $detail->delete();
        return redirect()->back()->with('success', 'deleted');
    }

    public function employeestatus($id, $status)
    {   
        if($status== '1' ){
            $status = '0';
        }else{ 
            $status = '1';
        }
        $detail = Employee::where('id', $id)->update(['status' => $status]);
        return redirect()->back()->with('success', 'Status changed');
    }

    public function employeeEdit($id)
    {
        $detail = Employee::find($id);
        return view('manager.employee.edit', compact('detail'));
    }

    public function editemployee(Request $request, $id)
    { 
    	$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => 'required|max:10|unique:users,mobile,'. $id.',id',
            'address' => 'required',
            'proof' => 'image|mimes:jpeg,png,jpg|max:2048',
            'police_verify'=>'required',
            'join_date'=>'required',
            'salary'=>'required',
           ]);
    	if ($request->file('proof'))
        {
            $name = $request->file('proof')->getClientOriginalName();
            $destinationPath = public_path('proof/');
            $request->file('proof')->move($destinationPath,$name);
        } 
        $model = Employee::findOrFail($id);
         if ($request->hasFile('proof'))
        {
            $model->proof = $name;
        }
        $model->update($request->except(['proof']));
        \Session::flash('success','message|Employee updated successfully!');
     return redirect()->back()
            ->with('success', 'updated successfully.');
    }

    public function employeeView()
    {	
    	$log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $model = Employee::where("role_id",'>','2')->where("parent_id",$id)->orderBy('id', 'asc')->get();
        return view('manager.employee.view', ['model' => $model]);
    }


}
