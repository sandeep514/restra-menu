<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Response;
use Redirect;
use DNS1D; 
use App\Models\{Country, State, City};
use App\Models\Restuarant_list;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Storage;


class Main extends Controller
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
    public function index()
    {
        $model=Restuarant_list::orderBy('id','asc')->get();

        return view('admin.home',['model'=>$model]);
    }

 
     public function addresturant()
    {
        $data['countries'] = Country::get(["name", "id"]);
        // $data['countries'] = Country::has('states_id','cities_id')->get(["name", "id"]);
        return view('admin/create',$data);
    }
 
     public function resturant_profile()
    {
        return view('manager/create-menu');
    }



     public function fetchState(Request $request)
    {
        $data['states'] = State::where("country_id",$request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("state_id",$request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
     
   public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|unique:restuarant_list|max:50',
            'location' => 'required|max:100',
            'contact' =>'required|unique:restuarant_list|max:10|',
            'description' =>'required|max:500|',
            'country' => 'required',
            'state' => 'required', 
            'logo' =>'image|mimes:jpeg,png,jpg|max:2048',
            'city' => 'required',
            'email' => 'required|unique:users',
            'password' =>'required',
            'member_type'=>'required',
            'membership_interval'=>'required',
            'expiry_date'=>'required',
        ]);
         if ($request->file('logo'))
        {
             $name = $request->file('logo')->getClientOriginalName();
            $destinationPath = public_path('images/');
            $request->logo->move($destinationPath, $name);
        } 
        $input = $request->all();
        // dd($input);
        $input['password'] = Hash::make($input['password']);
        $input['logo'] = $name;
        if($request->member_type=='1'){
           $input['membership_interval']=$request->membership_interval; 
        }
         else{
             $input['membership_interval']=$request->membership_interval; 
         }   

        $input['member_type']=$request->member_type; 
        $user=User::create($input);

        $input['user_id']=$user->id;
       $restra=Restuarant_list::create($input);
       $bar_id=$restra->id;
       $link="http://127.0.0.1:8000/restra/";
       $url="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=";
       
       $qrcode=$url.$link.$bar_id;
       $update=Restuarant_list::where('id',$bar_id)->update(['barcode'=>$qrcode]);
        return redirect()->route('admin.home')
            ->with('success', 'created successfully.');
    }

   
     public function editresturant($id)
    {
        $countries = Country::get(["name", "id"]);
        $detail = Restuarant_list::find($id);
        $user_detail = User::where('id',$detail->user_id)->get()->first();
        return view('admin.edit', compact('detail','countries','user_detail'));        
    }

    public function edit(Request $request,$id)
    {
        // dd($request); 
      $user=  $request->validate([
            'name' => 'required|max:50|unique:restuarant_list,name,'. $id.',id',
            'location' => 'required',
            'description' =>'required|max:500|',
            'country' => 'required',
            'state' => 'required',
             'city' => 'required',
            'logo' =>'image|mimes:jpeg,png,jpg|max:2048',
            'contact' =>'required|max:10|unique:restuarant_list,contact,'. $id.',id',
            'member_type'=>'required',
            'membership_interval'=>'required',
            'expiry_date'=>'required',
        ]);
       if ($request->file('logo'))
        {
            $name = $request->file('logo')->getClientOriginalName();
            $destinationPath = public_path('images/');
            $request->file('logo')->move($destinationPath,$name);
        }
         $user = Restuarant_list::findOrFail($id);
         $user_detail=User::findOrFail($user->user_id);
        if ($request->hasFile('logo'))
        {
            $user->logo = $name;
        }
        $input['member_type']=$request->member_type;
        $input['membership_interval']=$request->membership_interval;
        $input['expiry_date']=$request->expiry_date;
        $check=$user->update($request->except(['logo']));
        $check1= $user_detail->update($input);

        return redirect()->route('admin.home')->with('success', 'Restuarant updated');
    }

        public function destroy($id)
    {
        $detail = Restuarant_list::find($id);
        $detail->delete();
        return redirect()->route('admin.home')->with('success', 'Restuarant deleted');
    }

    public function status($id,$status)
    {
         if($status== '1' ){
            $status = '0';
        }else{
            $status = '1';
        }

        $detail =  Restuarant_list::where('id',$id)->update(['status'=>$status]);
        return redirect()->route('admin.home')->with('success', 'Status Changed');
    }

}
