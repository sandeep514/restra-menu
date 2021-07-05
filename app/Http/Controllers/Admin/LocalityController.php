<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Locality;
use App\User;
use App\Orders;




class LocalityController extends Controller
{

 public function loc_index()
 {

    $locs = Locality::pluck('area_name','id')->get();
   return view('admin.location.locality',compact('locs'));

 }


 public function loc_create()
 {

    $locs = Locality::select('area_name')->get();

 return view('admin.location.loc-create');

 }

 public function loc_Store(Request $request)
 {

    $loc = new Locality();
    $loc->area_name = $request->area_name;
    $loc->save();
return back();
 }
   /**
     * Show a role edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */

 public function loc_edit($id)
 {
    $locs = Locality::find($id);

return view('admin.location.edit', compact('locs'));

 }

public function loc_update(Request $request,$id)
{

    $locs = Locality::find($request->id);
$locs->area_name=$request['area_name'];
$locs->save();
return redirect()->route('loc');


}

public function loc_delete($id)
{

    $locs =Locality::where('id',$id)->first();
    if ($locs != null) {
    $locs->delete();
    return redirect()->route('loc');
    }

}


public function ajax_loc(Request $request)
{



    $request->validate([
        'orderId'       => 'required',
        'selectedloc'=> 'required'
    ]);

    $updateloc = Locality::where([ 'id' => $request->orderId ])->update([ 'pickup_emp' => $request->selectedpickup ]);

    if( $updateloc ){
        return response()->json([ 'status' => 'true' ] , 200);
    }else{
        return response()->json([ 'status' => 'false' ] , 500);
    }





}


public function filterCustomerByDate(Request $request)
    {
        // dd($request);
        $locality = $request->id_location;
        $userid = $request->user_id;
        $mobile = $request->phone;
         if((!empty($request->user_id)) && ($request->user_id!='Search Users')){

            $a =1;
            $AllOrders= Orders::where(['user_id'=>$request->user_id])->with(['user','location'])->orderby('id','desc')->get();

         }
        else if((!empty($request->phone)) && ($request->phone!='Search Contact')){
             $a=2;
           $AllOrders  = Orders::where(['mobile'=>$request->phone])
           ->with(['user','location'])->orderby('id','desc')->get();
        }
        else if((!empty($request->id_location)) && ($request->id_location!='Locality search')){
             $a=3;
            // $address = Locality::where('id',$request->id_location)->first();
            $address=$request->id_location;
            $explode=explode("|",$address);
            $areas_id=$explode[0];
            $areas_name=$explode[1];
            $AllOrders = Orders::where('address','LIKE',"%{$areas_name}%")->orWhere('id_location' , $areas_id)->with(['user','location'])->orderby('id','desc')->get();
        }

       else{

           $a=4;
           $AllOrders = [];
       }
      
        $locs =   Locality::pluck('area_name' , 'id');
        // $data = $AllOrders->groupBy('status');
        $users =   User::whereIn('role_id',[2,3])->pluck('name','id');
        $contact =   User::whereIn('role_id',[2,3])->pluck('mobile','id');
        return view('admin.location.loc-filter', compact('users','locs','AllOrders' ,'locality','userid','contact','mobile'));
    }
}
