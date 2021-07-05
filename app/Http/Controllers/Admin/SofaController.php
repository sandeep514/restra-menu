<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Categories;
use App\OrderItem;
use App\Products;
use App\ProductTypes;
use Redirect;
use Schema;
use App\Orders;
use App\Sofa;

use App\Http\Requests\CreateOrdersRequest;
use App\Http\Requests\UpdateOrdersRequest;
use Session;
use App\User;
use Illuminate\Support\Facades\Auth;

class SofaController extends Controller
{

public function report_sofa()
{
    // dd(auth::user()->role_id);
 $user = Auth::user();
//  $sofa  = \App\Products::where('categories_id',6)->with(['productType','categories'])->get()->take(10);
if(auth::user()->role_id == 1)
{
$sofabooks= Orders::whereIn('order_categories',[6, 10, 11])->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->orderBy('delv_time', 'DESC')->get();
$data = $sofabooks->groupBy('status');

$curDate=date('Y-m-d'); 
$pending= Orders::whereIn('order_categories',[6, 10, 11])->where('status',0)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->wheredate('delv_time','>=',$curDate)->orderBy('delv_time', 'DESC')->get();
$order_placed=Orders::whereIn('order_categories',[6, 10, 11])->where('status',0)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->wheredate('delv_time','<=',$curDate)->orderBy('delv_time', 'DESC')->get();
// $order_placed       = (!empty($data[0]))?$data[0]:collect([]);// Orders::where('status' , 0)->get();
$processing         = (!empty($data[1]))?$data[1]:collect([]);//Orders::where('status' , 1)->get();
$ready_for_deliver  = (!empty($data[2]))?$data[2]:collect([]); //Orders::where('status' , 2)->get();
$delivered          = (!empty($data[3]))?$data[3]:collect([]); //Orders::where('status' , 3)->get();
$order_cancelled    = (!empty($data[4]))?$data[4]:collect([]);//Orders::where('status' , 4)->get();


$pickupBoys = User::whereStatus(1)->where(['role_id' => 6])->pluck('name' , 'id')->prepend('Select Sofa boy' , 0);

// $pendingOrders = Orders::orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->limit(10)->get()->groupBy('pickup_time');
   $orderStatus = [
    0 => 'Order Placed',
    1 => 'Processing',
    2 => 'Ready for deliver',
    3 => 'Delivered',
    4 => 'Order Cancelled'
];

if($pickupBoys !== null)
{
return view('admin.sofa.sofa-report',compact('sofabooks','pickupBoys','orderStatus','order_placed','delivered','pending'));
}
return view('admin.sofa.sofa-report',compact('sofabooks','orderStatus','pending'));

// $products = Products::with("sofa_rel")->where('categories_id',6)->get();
}
elseif(auth::user()->role_id == 5){
$order_placed= Orders::whereIn('order_categories',[1, 2, 3,4,5])->where('pickup_emp',auth::id())->orderBy('delv_time', 'DESC')->get();
$data = $order_placed->groupBy('status');

// $order_placed       = (!empty($data[0]))?$data[0]:collect([]);// Orders::where('status' , 0)->get();
$processing         = (!empty($data[1]))?$data[1]:collect([]);//Orders::where('status' , 1)->get();
$ready_for_deliver  = (!empty($data[2]))?$data[2]:collect([]); //Orders::where('status' , 2)->get();
$delivered          = (!empty($data[3]))?$data[3]:collect([]); //Orders::where('status' , 3)->get();
$order_cancelled    = (!empty($data[4]))?$data[4]:collect([]);//Orders::where('status' , 4)->get();
$pickupBoy = User::where(['role_id' => 5])->pluck('name' , 'id');

    // $pendingOrders = Orders::orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->limit(10)->get()->groupBy('pickup_time');
       $orderStatus = [
        0 => 'Order Placed',
        1 => 'Processing',
        2 => 'Ready for deliver',
        3 => 'Delivered',
        4 => 'Order Cancelled'
       ];

       return view('admin.sofa.sofa-report',compact('orderStatus','pickupBoy','order_placed','delivered'));

}

elseif(auth::user()->role_id == 6){
$order_placed= Orders::whereIn('order_categories',[6, 10, 11])->where('pickup_emp',auth::id())->orderBy('delv_time', 'DESC')->get();
$data = $order_placed->groupBy('status');

// $order_placed       = (!empty($data[0]))?$data[0]:collect([]);// Orders::where('status' , 0)->get();
$processing         = (!empty($data[1]))?$data[1]:collect([]);//Orders::where('status' , 1)->get();
$ready_for_deliver  = (!empty($data[2]))?$data[2]:collect([]); //Orders::where('status' , 2)->get();
$delivered          = (!empty($data[3]))?$data[3]:collect([]); //Orders::where('status' , 3)->get();
$order_cancelled    = (!empty($data[4]))?$data[4]:collect([]);//Orders::where('status' , 4)->get();
$pickupBoy = User::where(['role_id' => 6])->pluck('name' , 'id');

    // $pendingOrders = Orders::orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->limit(10)->get()->groupBy('pickup_time');
       $orderStatus = [
        0 => 'Order Placed',
        1 => 'Processing',
        2 => 'Ready for deliver',
        3 => 'Delivered',
        4 => 'Order Cancelled'
       ];

       return view('admin.sofa.sofa-report',compact('orderStatus','pickupBoy','order_placed','delivered'));

}

}





public function sofa_edit($id)
{

    $id = base64_decode($id);
    $val = Orders::find($id);

    //  dd($val);

return view('admin.sofa.edit',['Orders'=>$val]);
}

public function sofa_update(Request $request)
{
    // $users= User::where(['id' => $request->id])->update(['name' => $request->name]);

    $updateOrder = Orders::where([ 'id' => $request->id ])->update([ 'address' => $request->address,'delv_time'=>$request->delv_time,'delv_time'=>$request->delv_time,'mobile'=>$request->mobile]);

        return back();

}


 /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
public function view_sofa($id){

      $order = Orders::find($id);


    $timeSlots = [
        'slot1' => '8:00 AM-10:00 PM',
        'slot2' => '10:00 AM-12:00 PM',
        'slot3' => '12:00 PM-03:00 PM',
        'slot4' => '03:00 PM-05:00 PM',
        'slot5' => '05:00 PM-08:00 PM'
    ];
    return view('admin.sofa.view',['orderDetails'=>$order,'time_slots'=>$timeSlots]);
}

 /**
       * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
	public function sofa_destroy($id)
	{
		Orders::destroy($id);
           return back();
	}



public function sofa_bill($id)
{
    $order =Orders::find($id);


    $timeSlots = [
        'slot1' => '8:00 AM-10:00 PM',
        'slot2' => '10:00 AM-12:00 PM',
        'slot3' => '12:00 PM-03:00 PM',
        'slot4' => '03:00 PM-05:00 PM',
        'slot5' => '05:00 PM-08:00 PM'
    ];

    $pickupBoys = User::whereStatus(1)->where(['role_id' => 6])->pluck('name' , 'id');
// $pendingOrders = Orders::orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->limit(10)->get()->groupBy('pickup_time');
   $orderStatus = [
    0 => 'Order Placed',
    1 => 'Processing',
    2 => 'Ready for deliver',
    3 => 'Delivered',
    4 => 'Order Cancelled'
];
        $products = Products::select('discount_product')->get();

    return view('admin.sofa.bill',['orderDetails'=>$order,'time_slots'=>$timeSlots,'pickupBoys'=>$pickupBoys],compact('products'));



}


public function add_bill(Request $request)
{
    foreach($request['order_item_id'] as $key => $value)
    {
    echo $request['discount'][$key];


         OrderItem::whereId($value)->update(['discount'=>$request['discount'][$key] ]);

    }


    $dis_product = Products::where(['id' => $request->id])->update(['discount_product' => $request->discount_product]);

    $afterdisc = Orders::where([ 'id' => $request->id ])->update([ 'after_discount' => $request->after_discount,'discount_percentage'=>$request->discount_percentage,'discount_type'=>$request->discount_type]);


return back();


}

public function sofa_date(Request $request)
{

 $request->validate([
     'from_date' => 'required'
 ]);
 $sofabooks= Orders::where('order_categories',6)->where('pickup_time' ,'<=', $request->from_date)->orderBy('id', 'DESC')->get();
 $data = $sofabooks->groupBy('status');

$order_placed       = (!empty($data[0]))?$data[0]:collect([]);// Orders::where('status' , 0)->get();
$processing         = (!empty($data[1]))?$data[1]:collect([]);//Orders::where('status' , 1)->get();
$ready_for_deliver  = (!empty($data[2]))?$data[2]:collect([]); //Orders::where('status' , 2)->get();
$delivered          = (!empty($data[3]))?$data[3]:collect([]); //Orders::where('status' , 3)->get();
$order_cancelled    = (!empty($data[4]))?$data[4]:collect([]);//Orders::where('status' , 4)->get();

 $pickupBoys = User::where(['role_id' => 6])->pluck('name' , 'id');
 $from_date = $request->from_date;
 // $order_placed  = Orders::orderBy( 'id' , 'DESC' )->whereDate('pickup_time' , $request->from_date)->whereStatus(0)->with(['pickupEmp'])->get();
 // $delivered  = Orders::orderBy( 'id' , 'DESC' )->whereDate('pickup_time' , $request->from_date)->whereStatus(3)->with(['pickupEmp'])->get();
 // dd($order_placed);
    return view('admin.sofa.sofa-report' , compact('order_placed','from_date','pickupBoys','delivered'));
}

 public function print_bill($id)
 {
    $order =Orders::find($id);


    $timeSlots = [
        'slot1' => '8:00 AM-10:00 PM',
        'slot2' => '10:00 AM-12:00 PM',
        'slot3' => '12:00 PM-03:00 PM',
        'slot4' => '03:00 PM-05:00 PM',
        'slot5' => '05:00 PM-08:00 PM'
    ];

    $pickupBoys = User::whereStatus(1)->where(['role_id' => 6])->pluck('name' , 'id');
// $pendingOrders = Orders::orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->limit(10)->get()->groupBy('pickup_time');
   $orderStatus = [
    0 => 'Order Placed',
    1 => 'Processing',
    2 => 'Ready for deliver',
    3 => 'Delivered',
    4 => 'Order Cancelled'
];
    return view('admin.sofa.print',['orderDetails'=>$order,'time_slots'=>$timeSlots,'pickupBoys'=>$pickupBoys]);




 }

 public function updateOrderStatuss(Request $request)
    {
        $request->validate([
            'orderId'       => 'required',

            'selectedOrder' => 'required'
        ]);

       $final_delivery=date('Y-m-d');
        // $updateStatus = Orders::where([ 'id' => $request->orderId ] )->update([ 'status' => $request->selectedOrder ]);
         $updateStatus = Orders::where([ 'id' => $request->orderId ] )->update([ 'status' => $request->selectedOrder,'final_delivery'=> $final_delivery]);
 
        $name = $request->userId;
        $pickname =$request->selectedPickup;
        // $mobileNumber = $request->mobileNo;

        $status = $request->selectedOrder;

        if($status == 1)

        {


            if( $updateStatus ){

            $apiKey = urlencode('OWE2YzVkYmI3NzUxNWUwMjQ1YjhkNWJkZjEyMjhiM2E=');
            // Message details
            $numbers = array($request['mobileNo']);
            $sender = urlencode('CLNFLD');
            $ordernumber = $request['orderId'];
            $message = rawurlencode("Clean Fold has assigned executive for your Sofa Spa Service. Our $pickname will contact your shortly. His contact detail is ( Mbl - 8558989125 ).%n %nClean Fold");
            $numbers = implode(',', $numbers);
            // Prepare data for POST request
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            // Process your response here
            echo $response;

                return response()->json([ 'status' => 'true' ] , 200);


            }
            else
            {
                return response()->json([ 'status' => 'false' ] , 500);
            }

        }
        elseif($status == 3 )
           {

               if( $updateStatus ){
                $apiKey = urlencode('OWE2YzVkYmI3NzUxNWUwMjQ1YjhkNWJkZjEyMjhiM2E=');

                // Message details
                $numbers = array($request['mobileNo']);
                $sender = urlencode('CLNFLD');
                $ordernumber = $request['orderId'];
                $message = rawurlencode("Your Sofa Spa Service has been delivered by Clean Fold. We Dry Clean Cloths, Curtains, Blankets, Households, Car, Sofa & Carpets.Call-9646222333%nClean Fold");
                $numbers = implode(',', $numbers);
                // Prepare data for POST request
                $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
                // Send the POST request with cURL
                $ch = curl_init('https://api.textlocal.in/send/');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                // Process your response here
                echo $response;


               return response()->json([ 'status' => 'true' ] , 200);

               }
               else
               {
            return response()->json([ 'status' => 'false' ] , 500);
               }



        }else

                if( $updateStatus ){

                 return response()->json([ 'status' => 'true' ] , 200);

                  }
                else
                  {
            return response()->json([ 'status' => 'false' ] , 500);
                  }

                }

}
