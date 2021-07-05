<?php

namespace App\Http\Controllers\Admin;

use App\Categories;
use App\Http\Controllers\Controller;
use App\OrderItem;
use App\Products;
use App\ProductTypes;
use Redirect;
use Schema;
use App\Orders;
use App\Locality;

use App\Http\Requests\CreateOrdersRequest;
use App\Http\Requests\UpdateOrdersRequest;
use Illuminate\Http\Request;
use Session;
use App\User;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller {

	/**
	 * Display a listing of orders
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    { 

        $AllOrders = Orders::select([ 'id', 'number', 'amount', 'after_discount', 'discount_percentage', 'status', 'discount_type', 'payment_status', 'pickup_status', 'pickup_slot', 'delv_slot', 'pickup_time', 'pickup_emp', 'delv_time', 'delivery_emp', 'address', 'mobile', 'coupon', 'user_id', 'order_type','order_through','remarks', 'order_categories','id_location', 'order_from','created_at'])->whereNotIn('order_categories',[6, 10, 11])
                            ->whereYear('created_at', date('Y'))->orderby('id','desc')->get();
        
     $processing=Orders::select([ 'id', 'number', 'amount', 'after_discount', 'discount_percentage', 'status', 'discount_type', 'payment_status', 'pickup_status', 'pickup_slot', 'delv_slot', 'pickup_time', 'pickup_emp', 'delv_time', 'delivery_emp', 'address', 'mobile', 'coupon', 'user_id', 'order_type','order_through','remarks', 'order_categories','id_location', 'order_from','created_at'])->whereNotIn('order_categories',[6, 10, 11])->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))
     ->where('status',1)->orderby('id','desc')->get();
        
     $curDate=date('Y-m-d'); 
    $ready_for_deliver=Orders::select([ 'id', 'number', 'amount', 'after_discount', 'discount_percentage', 'status', 'discount_type', 'payment_status', 'pickup_status', 'pickup_slot', 'delv_slot', 'pickup_time', 'pickup_emp', 'delv_time', 'delivery_emp', 'address', 'mobile', 'coupon', 'user_id', 'order_type','order_through','remarks', 'order_categories','id_location', 'order_from','created_at'])->whereNotIn('order_categories',[6, 10, 11])->whereYear('created_at', date('Y'))
     ->where('delv_time','<=',$curDate)->where('status',1)->orwhere('status',2)->where('delv_time','>=',$curDate)->orderby('id','desc')->get();
     
     $delivered=Orders::select([ 'id', 'number', 'amount', 'after_discount', 'discount_percentage', 'status', 'discount_type', 'payment_status', 'pickup_status', 'pickup_slot', 'delv_slot', 'pickup_time', 'pickup_emp', 'final_delivery', 'delivery_emp', 'address', 'mobile', 'coupon', 'user_id', 'order_type','order_through','remarks', 'order_categories','id_location', 'order_from','created_at'])->whereNotIn('order_categories',[6, 10, 11])->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))
     ->where('status','=','3')->orderby('id','desc')->get();
     
     $order_cancelled=Orders::select([ 'id', 'number', 'amount', 'after_discount', 'discount_percentage', 'status', 'discount_type', 'payment_status', 'pickup_status', 'pickup_slot', 'delv_slot', 'pickup_time', 'pickup_emp', 'final_delivery', 'delivery_emp', 'address', 'mobile', 'coupon', 'user_id', 'order_type','order_through','remarks', 'order_categories','id_location', 'order_from','created_at'])->whereNotIn('order_categories',[6, 10, 11])->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))
     ->where('status','=','4')->orderby('id','desc')->get();
                            
                            
        $data = $AllOrders->groupBy('status');
        
        $order_placed       = (!empty($data[0]))?$data[0]:collect([]);// Orders::where('status' , 0)->get();
        // $processing         = (!empty($data[1]))?$data[1]:collect([]);//Orders::where('status' , 1)->get();
        // $ready_for_deliver  = (!empty($data[2]))?$data[2]:collect([]); //Orders::where('status' , 2)->get();
        // $delivered          = (!empty($data[3]))?$data[3]:collect([]); //Orders::where('status' , 3)->get();
        // $order_cancelled    = (!empty($data[4]))?$data[4]:collect([]);//Orders::where('status' , 4)->get();


        $pickupBoys = User::whereStatus(1)->where(['role_id' => 5])->pluck('name' , 'id')->prepend('Please select pickup boy' , 0);
        $sofaboys = User::whereStatus(1)->where(['role_id' => 6])->pluck('name' , 'id')->prepend('Please select sofa boy' , 0);    

 		return view('admin.orders.index', compact('AllOrders','order_placed','processing','ready_for_deliver','delivered','order_cancelled','data','pickupBoys','sofaboys'));
	}

    // public function show_all()
    // {



    //    return view('admin.orders.index' ,compact('show'));


    // }









    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'orderId'       => 'required',

            'selectedOrder' => 'required'
        ]);

        $final_delivery=date('Y-m-d');
        $updateStatus = Orders::where([ 'id' => $request->orderId ] )->update([ 'status' => $request->selectedOrder,'final_delivery'=> $final_delivery]);
        // $updateStatus = Orders::where([ 'id' => $request->orderId ] )->update([ 'status' => $request->selectedOrder ]);


        $name = $request->userId;
        // $mobileNumber = $request->mobileNo;

        $status = $request->selectedOrder;

        if($status == 3)

        {


            if( $updateStatus ){

            $apiKey = urlencode('OWE2YzVkYmI3NzUxNWUwMjQ1YjhkNWJkZjEyMjhiM2E=');
            // Message details
            $numbers = array($request['mobileNo']);
            $sender = urlencode('CLNFLD');
            $ordernumber = $request['orderId'];
            $message = rawurlencode("ARRIVING TODAY%n %nClean Fold's Delivery Agent ( Mbl - 8558989127 ) ll contact you shortly for your order Delivery at your Doorstep.");
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
        elseif($status == 4 )
           {

               if( $updateStatus ){

                $apiKey = urlencode('OWE2YzVkYmI3NzUxNWUwMjQ1YjhkNWJkZjEyMjhiM2E=');

                // Message details
                $numbers = array($request['mobileNo']);
                $sender = urlencode('CLNFLD');
                $ordernumber = $request['orderId'];
                $message = rawurlencode("Dear $name as per your request we have successfully cancelled your order # $ordernumber%nFor further query Call - 9646-222-333 - Clean Fold");
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
            {

                if( $updateStatus ){

                    return response()->json([ 'status' => 'true' ] , 200);

                     }
                   else
                     {
               return response()->json([ 'status' => 'false' ] , 500);
                     }

                    }

    }


	/**
	 * Show the form for creating a new orders
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{


	    $user = User::whereStatus(1)->pluck("name", "id")->prepend('Please selects', 0);


        $lastOrderNumber = Orders::get()->last();
        $nextOrderNumber = 1;
        if( $lastOrderNumber != null ){
            $nextOrderNumber = ($lastOrderNumber->number+1);
        }

        $pickupBoys = User::whereStatus(1)->where(['role_id' => 5])->pluck('name' , 'id')->prepend('Please select pickup boy' , 0);
        $sofaboys = User::whereStatus(1)->where(['role_id' => 6])->pluck('name' , 'id')->prepend('Please select sofa boy' , 0);    
        $categories = Categories::get();
        $timeSlots = [
            'slot1' => '8:00 AM-10:00 PM',
            'slot2' => '10:00 AM-12:00 PM',
            'slot3' => '12:00 PM-03:00 PM',
            'slot4' => '03:00 PM-05:00 PM',
            'slot5' => '05:00 PM-08:00 PM'
        ];
        $locs = Locality::select('id','area_name')->get();

	    return view('admin.orders.create', compact("user",'nextOrderNumber','categories' , 'pickupBoys','locs','sofaboys'));
	}

    /**
     * @param CreateOrdersRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function store(Request $request)
	{
		$order= Orders::create($request->all());

		 return redirect()->route(config('coreadmin.route').'.orders.index');
	}

	/**
	 * Show the form for editing the specified orders.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{



        $user = User::pluck("name", "id")->prepend('Please select', 0);
        $orders = Orders::with(['OrderItem'=>function($model){
            return $model->with(['product'=>function($model){
                return $model->with(['categories','productType']);
            }]);

        }])->find($id);

        $mobile = $orders->mobile;

        $selectedUser = User::where(['mobile' => $mobile])->first();

        $selectedProducts = OrderItem::where('order_id' , $orders->id )->get()->map(function($query){
            return $query->product_id;
        });
        $selectedProductsArray = [];
        if( $selectedProducts->count() > 0 ){
            $selectedProductsArray = $selectedProducts->toArray();
        }

        $pickupBoys = User::where(['role_id' => 5])->pluck('name' , 'id')->prepend('Please select pickup boy' , 0);
        $sofaboys = User::whereStatus(1)->where(['role_id' => 6])->pluck('name' , 'id')->prepend('Please select sofa boy' , 0);    
        $timeSlots = [
            'slot1' => '8:00 AM-10:00 PM',
            'slot2' => '10:00 AM-12:00 PM',
            'slot3' => '12:00 PM-03:00 PM',
            'slot4' => '03:00 PM-05:00 PM',
            'slot5' => '05:00 PM-08:00 PM'
        ];

        $categories = Categories::get();

        $locs = Locality::select('id','area_name')->get();

		return view('admin.orders.edit', compact('selectedUser' , 'selectedProductsArray','locs','user','orders', "user",'timeSlots','categories','pickupBoys','sofaboys'));
	}

    /**
     * @param $id
     * @param UpdateOrdersRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function update($id, UpdateOrdersRequest $request)
	{

		$orders = Orders::findOrFail($id);
		$orders->update($request->all());

		return redirect()->route(config('coreadmin.route').'.orders.index');
	}

    public function orderUpdate(Request $request)
    {
        // dd($request);
        $selectedProducts = $request->product;
         $products = null;
        $price = 0;


        if($selectedProducts != null){
            $products = Products::whereIn('id' , $selectedProducts)->get()->map(function($query){
                return $query->price;
            });
        }
        if($products != null){
            if( $products->count() > 0 ) {
                $productArray = $products->toArray();
                $price = count($productArray);
            }else{
                $price = 0;
            }
        }

        $request->validate([
            "number"        => 'required',
            "mobile"        => 'required|integer|digits:10',
            "id_location"   => 'required',
            "city"          => 'required',
            "pincode"       => 'required|integer',
            "State"         => 'required',
            'pickup_time'   => 'required',
            'delv_time'     => 'required',
            'pickupboy'     => 'required'
        ]);

        User::where('mobile' , $request->mobile)->update([
            'address' => $request->Hno.','.$request->street.','.$request->city.','.$request->pincode.','.$request->State,
            'Hno' => $request->Hno,
            'street' => $request->street,
            // 'locality' => $request->locality,

            'city' => $request->city,
            'pincode' => $request->pincode,
            'State' => $request->State
        ]);

        $user = User::where(['mobile' => $request->mobile])->first();



        $orders = Orders::where(['id' => $request->orderId])->update([
            'number'            => $request->number,
            'order_categories'  => $request->category,
            'status'            => 0,
            'payment_status'    => 'by_cash',
            'pickup_status'     => 0,
            // 'pickup_time'       => $request->pickup_time,
            // 'delv_time'         => $request->delv_time,
            'pickup_time' => date_format( date_create($request->pickup_time)  , 'Y-m-d' ),
            'delv_time' => date_format( date_create($request->delv_time)  , 'Y-m-d' ),
            'remarks'           =>$request->remarks,
            'pickup_emp'        => $request->pickupboy,
            'address'           => 'Amritsar',
            'mobile'            => $request->mobile,
            'user_id'           => $user->id,
            'order_type'        => 'normal',
            'amount'            => $price,
            'id_location'       =>$request->id_location
        ]);

        $orderId = $request->orderId;

        OrderItem:: where(['order_id' => $orderId])->delete();
        $user = User::where(['mobile' => $request->mobile])->first();




      if($selectedProducts && $price != null){
            foreach ($selectedProducts as $key => $value) {
                $products = Products::where('id' , $value)->first();
                $price = $products->price;
                OrderItem::create([
                    'order_id' => $orderId,
                    'product_id' => $value,
                    'price' => $price,
                    'qty' =>$request->qty[$key],
                    'total_amount' => $price
                ]);

            }
        }


        // OrdersController::createOrderByAdmin($request->all());
        Session::flash('success' , 'Order updated successfully');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
	public function order_destroy($id)
	{
		Orders::destroy($id);

		return redirect()->route(config('coreadmin.route').'.orders.index');
	}
	
	
	
    public function orderitem_destroy($id)
    {
           $orderdiscountAmount = orderItem::find($id);
        $singleproduct = $orderdiscountAmount->price;
        $payableAmount = $orderdiscountAmount->total_amount;
        $order_id = $orderdiscountAmount->order_id;
        $getdiscountamt = Orders::find($order_id);
        // dd($getdiscountamt);
        $amounts = $getdiscountamt->amount;
        $discountAmount = $getdiscountamt->after_discount2;
        $discountpercent = $getdiscountamt->discount_percentage;
        $after_discount2= round(($payableAmount * $discountpercent )/100) ;
        $total_discount = $payableAmount - $after_discount2;
        $final_discount=$discountAmount-$total_discount;
        $discounts=$amounts-$payableAmount;
        // dd($payableAmount,$discountAmount,$after_discount2,$total_discount,$final_discount);
        if($final_discount<=0){
        $finaldiscount2=0;    
        }
        else{
        $finaldiscount2=$final_discount;    
        }
        if($discounts<=0)
        {
            $discount=0;
        }
        else{
            $discount=$discounts;
        }

        $discount2 = Orders::where([ 'id' => $order_id])->update(['after_discount2' => $finaldiscount2,'after_discount'=>$discount,'amount'=>$discount]);

        orderItem::destroy($id);
        Session::flash('success' , 'Order Deleted successfully');
        return back();
    }

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Orders::destroy($toDelete);
        } else {
            Orders::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.orders.index');
    }

    public function getOrderDetails($id){
    	$order = Orders::find($id);
    	return response()->json(['status'=>true,'data'=>$order->toArray()]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id){
        $order = Orders::with(['OrderItem'=>function($model){
            return $model->with(['product'=>function($model){
                return $model->with(['categories','productType']);
            }]);
        },'user'])->find($id);
        $timeSlots = [
            'slot1' => '8:00 AM-10:00 PM',
            'slot2' => '10:00 AM-12:00 PM',
            'slot3' => '12:00 PM-03:00 PM',
            'slot4' => '03:00 PM-05:00 PM',
            'slot5' => '05:00 PM-08:00 PM'
        ];
        return view('admin.orders.view',['orderDetails'=>$order,'time_slots'=>$timeSlots]);
    }


    public function productDetails($type,$id, $prod_type_id = null){
        if($type == 'category'){
            $products = Products::where(['categories_id'=>$id])->get();
            $productTypes = $products->groupBy('product_type')->keys();
            $types = ProductTypes::whereIn('id',$productTypes)->pluck('type_name','id');
            return response()->json(['array'=>$types]);
        }

        if($type == 'product'){
            $products = Products::where(['categories_id'=>$id,'product_type'=>$prod_type_id])->pluck('title','id');
            return response()->json(['array'=>$products]);
        }

        if($type == 'product_details'){
            $productDetails = Products::find($id);
            return response()->json(['details'=>$productDetails->toArray()]);
        }
    }


    public function addItemInOrder(Request $request){
        $orderItem = new OrderItem;
        $orderItem->order_id = $request->order_id;
        $orderItem->product_id = $request->product;
        $orderItem->qty = $request->qty;
        $orderItem->price = $request->price;
        $orderItem->total_amount = $request->price * $request->qty;
        $orderItem->save();
        $this->updatePayableAmount($request->order_id);
        return back();
    }

    protected function updatePayableAmount($orderId){
        $orderItems = OrderItem::where('order_id',$orderId)->get();
        $payableAmount = 0;
        foreach($orderItems as $key => $item){
            $payableAmount += $item->price * $item->qty;
        }
        $orderPayableAmount = Orders::find($orderId);
        $orderPayableAmount->after_discount = $payableAmount;
        $orderPayableAmount->amount = $payableAmount;
        $orderPayableAmount->save();
    }

    public function itemsUpdate(Request $request){
        if($request->qty != null){
            foreach($request->qty as $id => $qty){
                $orderItem = OrderItem::find($id);
                $orderItem->qty = $qty;
                $orderItem->save();
            }
        }


        if($request->to_delete != null){
            $idsToDelete = json_decode($request->to_delete,true);
            foreach($idsToDelete as $k => $id){
                $orderItem = OrderItem::find($id);
                $orderItem->delete();
            }
            $this->updatePayableAmount($orderItem->order_id);
        }
        return back();
    }

    public function adminOrdersCreate()
    {
        return view('admin.orders.create');
    }
    public static function createOrderByAdmin($data)
    {
        $productId = $data['product'];
        $product = Products::whereIn('id' , $productId)->get()->map(function($query){
            return $query->price;
        });
        $productPriceArray = $product->toArray();
        $user = User::where('mobile' , $data['mobile'])->first();
        $userId = $user->id;

        $pickupDate = date_format( date_create($data['pickup_time'])  , 'Y-m-d' );
        $deliveryDate = date_format( date_create($data['delv_time'])  , 'Y-m-d' );

        Orders::create([
            'number'            => $data['number'],
            'amount'            => array_sum($productPriceArray),
            'status'            => 0,
            'payment_status'    => 'by_cash',
            'pickup_status'     => 0,
            'pickup_slot'       => $data['pickup_slot'],
            'delv_slot'         => $data['delivery_slot'],
            'pickup_time'       => $pickupDate,
            'delv_time'         => $deliveryDate,
            'address'           => $user['address'],
            'mobile'            => $data['mobile'],
            'user_id'           => $userId,
            'order_type'        => 'normal',
        ]);
        return true;
    }

   public function filterOrderByDate(Request $request)
    {
         $AllOrders = Orders::select([ 'id', 'number', 'amount', 'after_discount', 'discount_percentage', 'status', 'discount_type', 'payment_status', 'pickup_status', 'pickup_slot', 'delv_slot', 'pickup_time', 'pickup_emp', 'delv_time', 'delivery_emp', 'address', 'mobile', 'coupon', 'user_id', 'order_type','order_through','remarks', 'order_categories','id_location', 'order_from','created_at'])->whereNotIn('order_categories',[6, 10, 11])->where('status','0')->orderby('id','desc')->get();

        $order_query = Orders::whereDate('created_at' ,'>=' ,$request->from_date )->whereDate('created_at' ,'<=',$request->to_date)->whereNotIn('order_categories',[6, 10, 11]);
        $pickupBoys = User::whereStatus(1)->where(['role_id' => 5])->pluck('name' , 'id')->prepend('Please select pickup boy' , 0);
        $sofaboys = User::whereStatus(1)->where(['role_id' => 6])->pluck('name' , 'id')->prepend('Please select sofa boy' , 0);    
        if( !empty($request->user_id) && !empty($request->id_location)) {

            $a =1;
            $OrdersAll          = $order_query->where(['user_id'=>$request->user_id, 'id_location'=>$request->id_location])
            ->with(['user','location'])->orderby('id','desc')->get();
       }else if( !empty($request->user_id) && empty($request->id_location) ) {
           $a=2;
           $OrdersAll          = $order_query->where(['user_id'=>$request->user_id ])
           ->with(['user','location'])->orderby('id','desc')->get();
        }else if( empty($request->user_id) && empty($request->id_location) ) {
            $a=3;
            $OrdersAll = $order_query->with(['user','location'])->orderby('id','desc')->get();

       }else if  (empty($request->user_id) && !empty($request->id_location) ) {
        $a=5;
        $OrdersAll           = $order_query->where('id_location' ,$request->id_location )
        ->with(['user','location'])->orderby('id','desc')->get();

       }else{

           $a=8;

           $OrdersAll          = Orders::all();
       }


        $filter = $request->from_date;
        $tofilter = $request->to_date;

      $data = $OrdersAll->groupBy('status');
      $datas = $AllOrders->groupBy('status');


        $order_placed       = (!empty($datas[0]))?$datas[0]:collect([]);//Orders::whereDate('created_at' ,'>=' ,$request->from_date )->whereDate('created_at' ,'<=',$request->to_date)->where('status' , 0)->get();
        $processing         =(!empty($data[1]))?$data[1]:collect([]);//Orders::whereDate('created_at' ,'>=' ,$request->from_date )->whereDate('created_at' ,'<=',$request->to_date)->where('status' , 1)->get();
        $ready_for_deliver  = (!empty($data[2]))?$data[2]:collect([]);//Orders::whereDate('created_at' ,'>=' ,$request->from_date )->whereDate('created_at' ,'<=',$request->to_date)->where('status' , 2)->get();
        $delivered          = (!empty($data[3]))?$data[3]:collect([]);//Orders::whereDate('created_at' ,'>=' ,$request->from_date )->whereDate('created_at' ,'<=',$request->to_date)->where('status' , 3)->get();
        $order_cancelled    = (!empty($data[4]))?$data[4]:collect([]);;//Orders::whereDate('created_at' ,'>=' ,$request->from_date )->whereDate('created_at' ,'<=',$request->to_date)->where('status' , 4)->get();

        return view('admin.orders.index', compact('AllOrders','order_placed','processing','ready_for_deliver','delivered','order_cancelled','filter','tofilter','pickupBoys','sofaboys'));

    }


    public function listPendingPickups()
    {
        $user = Auth::user();
        if(auth::user()->role_id == 1)
        {
            $pickupBoys = User::whereStatus(1)->where(['role_id' => 5])->pluck('name' , 'id')->prepend('Please select pickup boy' , 0);
            // $sofaboys = User::whereStatus(1)->where(['role_id' => 6])->pluck('name' , 'id')->prepend('Please select sofa boy' , 0);    

            $pick = [
                0 => 'slot1',
                1 => 'slot2',
                2 => 'slot3',
                3 => 'slot4',
                4 => 'slot5'
            ];

            // $pendingOrders = Orders::where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');

            $pending = Orders::where('status',0)->whereNotIn('order_categories',[6, 10, 11])->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');
            return view('admin.reports.pending' , compact('pending' , 'pickupBoys','pick'));


        }elseif(auth::user()->role_id == 5)
        {

            $pickupBoys = User::whereStatus(1)->where(['role_id' => 5])->pluck('name' , 'id');

            $pick = [
                0 => 'slot1',
                1 => 'slot2',
                2 => 'slot3',
                3 => 'slot4',
                4 => 'slot5'
            ];

            $pending = Orders::where('pickup_emp',$user->id)->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');
            return view('admin.reports.pending' , compact('pending' , 'pickupBoys','pick'));

        }

       else{

        return view('admin.reports.pending');

       }

    }

    public function listpickupslotes(){


     $pickupslots = Orders::pluck('pickup_slot')->prepend('Please select pickup SLOT' , 0);

      return view('admin.reports.pending',['pickupslots']);


    }

    // order Bill

    public function order_bill($id)

    {
        $order =Orders::find($id);

        $timeSlots = [
            'slot1' => '8:00 AM-10:00 PM',
            'slot2' => '10:00 AM-12:00 PM',
            'slot3' => '12:00 PM-03:00 PM',
            'slot4' => '03:00 PM-05:00 PM',
            'slot5' => '05:00 PM-08:00 PM'
        ];

        $pickupBoys = User::whereStatus(1)->where(['role_id' => 5])->pluck('name' , 'id');
        // $sofaboys = User::whereStatus(1)->where(['role_id' => 6])->pluck('name' , 'id');
       $orderStatus = [
        0 => 'Order Placed',
        1 => 'Processing',
        2 => 'Ready for deliver',
        3 => 'Delivered',
        4 => 'Order Cancelled'
    ];

        $products = Products::select('discount_product')->get();

        return view('admin.orders.bill',['orderDetails'=>$order,'time_slots'=>$timeSlots,'pickupBoys'=>$pickupBoys],compact('products'));



    }
//   public function add_bill(Request $request)
//   {
//     if($request->product!=Null){   
     
//       for($count = 0; $count < count($request->product); $count++)
//       {
//         $data = array(
//         'order_id' => $request['id'][0],
//         'product_id'=> $request['product'][$count],
//         'qty'            => $request['qty'][$count],
//         'price'    => $request['price'][$count],
//         'discount'     => $request['discount'][$count],
//         'total_amount'       => $request['price'][$count],
//       );
              
//             OrderItem::create($data);
//       }} 

//       if(!empty($request->order_item_id)){
//       for($counts = 0; $counts < count($request->order_item_id); $counts++) {           

//          OrderItem::whereId($request['order_item_id'][$counts])->update(['order_id' => $request['id'][0],'product_id'=> $request['product_old'][$counts],'qty'=> $request['qty_old'][$counts],'price'=> $request['price_old'][$counts],'discount'=> $request['discount_old'][$counts],'total_amount'=> $request['price_old'][$counts],]);
//           Products::where(['id' => $request['id'][0]])->update(['discount_product' => $request['discount_old'][$counts]]);
//           Orders::where([ 'id' => $request['id'][0] ])->update([ 'after_discount' => $request->after_discount,'after_discount2' => $request->after_discount2,'discount_percentage'=>$request->discount_percentage,'discount_type'=>$request->discount_type]);

//       }
//      }
//      return back();
// }

  public function add_bill(Request $request)
   {
    // dd($request);
    if($request->product!=Null){   
      $sum=0;
      for($count = 0; $count < count($request->product); $count++)
      {
      $sum += $request['qty'][$count] * $request['price'][$count];     
       $data = array(
        'order_id' => $request['id'][0],
        'product_id'=> $request['product'][$count],
        'qty'            => $request['qty'][$count],
        'price'    => $request['price'][$count],
        'discount'     => $request['discount'][$count],
        'total_amount'       => $request['qty'][$count] * $request['price'][$count],
       );
            // Orders::where([ 'id' => $request['id'][0] ])->update(['amount'=>$request->after_discount,'after_discount' => $request->after_discount,'after_discount2' => $request->after_discount2,'discount_percentage'=>$request->discount_percentage,'discount_type'=>$request->discount_type]);  
            OrderItem::create($data);
            
      }
      Orders::where([ 'id' => $request['id'][0] ])->update(['amount'=>$sum,'after_discount' => $sum,'after_discount2'=>$request->after_discount2,'discount_percentage'=>$request->discount_percentage,'discount_type'=>$request->discount_type]);
        
    } 

      if(!empty($request->order_item_id)){
       for($counts = 0; $counts < count($request->order_item_id); $counts++) {           

         OrderItem::whereId($request['order_item_id'][$counts])->update(['order_id' => $request['id'][0],'product_id'=> $request['product_old'][$counts],'qty'=> $request['qty_old'][$counts],'price'=> $request['price_old'][$counts],'discount'=> $request['discount_old'][$counts],'total_amount'=> $request['qty_old'][$counts] * $request['price_old'][$counts]]);
          Products::where(['id' => $request['id'][0]])->update(['discount_product' => $request['discount_old'][$counts]]);
          Orders::where([ 'id' => $request['id'][0] ])->update(['amount'=>$request->after_discount,'after_discount' => $request->after_discount,'after_discount2' => $request->after_discount2,'discount_percentage'=>$request->discount_percentage,'discount_type'=>$request->discount_type]);

       }
    //   
     }
     return back();
}
  
//  create the new function by harsimran

    public function list_done_Pickups()
    {
        $user = Auth::user();

           if(auth::user()->role_id ==1 )
           {
            $pickupBoys = User::where(['role_id' => 5])->pluck('name' , 'id');


            $doneOrders = Orders::where('status',1)->whereNotIn('order_categories',[6, 10, 11])->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');
            return view('admin.reports.done-pickup',compact('doneOrders' , 'pickupBoys'));

           }

           elseif(auth::user()->role_id ==5 )

           {
            $pickupBoys = User::where(['role_id' => 5])->pluck('name' , 'id');

            $doneOrders = Orders::where('pickup_emp',$user->id)->where('status','=',1)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');
            return view('admin.reports.done-pickup',compact('doneOrders' , 'pickupBoys'));
           }
           else
           {

            $pickupBoys = User::where(['role_id' => 5])->pluck('name' , 'id');

            $doneOrders = Orders::whereIn('pickup_emp',$user->id)->Orders::where('status',1)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->where('status','=',1)->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');
            return view('admin.reports.done-pickup',compact('doneOrders' , 'pickupBoys'));
           }



    }

    public function delivered_list()
    {

        $user = Auth::user();
        if(auth::user()->role_id ==1 )
        {

          $delivered = Orders::where('status',3)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');

          return view('admin.reports.delivered',compact('delivered'));
        }

        elseif(auth::user()->role_id == 5)
        {

            $delivered = Orders::where('pickup_emp',$user->id)->where('status',3)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');

            return view('admin.reports.delivered',compact('delivered'));
        }
        else

        $delivered = Orders::where('status',3)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');

        return view('admin.reports.delivered',compact('delivered'));
    }

    public function ready_delivered_list()
    {

        $user = Auth::user();
        if(auth::user()->role_id ==1 )
        {

          $ready_delivered = Orders::where('status',2)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');

          return view('admin.reports.ready',compact('ready_delivered'));
        }

        elseif(auth::user()->role_id == 5)
        {

            $ready_delivered = Orders::where('pickup_emp',$user->id)->where('status',2)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');

            return view('admin.reports.ready',compact('ready_delivered'));
        }
        else

        $ready_delivered = Orders::where('status',2)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(10))->orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');

        return view('admin.reports.ready',compact('ready_delivered'));
    }

    public function filterPendingOrdersByDate(Request $request)
    {
        $request->validate([
            'from_date' => 'required'
        ]);

        $pickupBoys = User::where(['role_id' => 5])->pluck('name' , 'id');
        $from_date = $request->from_date;

        $pending = Orders::orderBy( 'id' , 'DESC' )->whereDate('pickup_time' , $request->from_date)->with(['pickupEmp'])->get()->groupBy('pickup_time');
        return view('admin.reports.pending' , compact('pending' , 'from_date','pickupBoys'));
    }

    public function donePendingOrdersByDate(Request $request)
    {
     $request->validate([
         'from_date' => 'required'
     ]);

     $pickupBoys = User::where(['role_id' => 5])->pluck('name' , 'id');
     $from_date = $request->from_date;
     $doneOrders = Orders::orderBy( 'id' , 'DESC' )->whereDate('pickup_time' , $request->from_date)->with(['pickupEmp'])->get()->groupBy('pickup_time');
        return view('admin.reports.done-pickup' , compact('doneOrders' , 'from_date','pickupBoys'));
    }


    public function deliverd_date(Request $request)
    {
     $request->validate([
         'from_date' => 'required'
     ]);


     $pickupBoys = User::where(['role_id' => 5])->pluck('name' , 'id');
     $from_date = $request->from_date;
     $delivered = Orders::orderBy( 'id' , 'DESC' )->whereDate('pickup_time' , $request->from_date)->with(['pickupEmp'])->get()->groupBy('pickup_time');
        return view('admin.reports.delivered' , compact('delivered','from_date','pickupBoys'));
    }

    public function updatePickupBoy(Request $request)
    {
        $request->validate([
            'orderId'       => 'required',
            'selectedpickup'=> 'required'
        ]);

        $updateOrder = Orders::where([ 'id' => $request->orderId ])->update([ 'pickup_emp' => $request->selectedpickup ]);

        if( $updateOrder ){
            return response()->json([ 'status' => 'true' ] , 200);
        }else{
            return response()->json([ 'status' => 'false' ] , 500);
        }
    }


    public function edit_report($id)
    {
     $orders = Orders::findOrFail($id);

     return view('admin.reports.edit',compact('orders'));

    }

    public function update_report(Request $request)
    {
        $orders = Orders::where([ 'id' => $request->id ])->update([ 'pickup_time' => $request->pickup_time,'pickup_slot' =>$request->pickup_slot,'remarks' =>$request->remarks ]);
        return Redirect::back()->withErrors(['Update succesfully', 'The Message']);

    }



     public function Order_confirmation()
     {

        $pickupBoys = User::whereStatus(1)->where(['role_id' => 5])->pluck('name' , 'id')->prepend('Please select pickup boy' , 0);
        $pendingOrders = Orders::orderBy( 'id' , 'DESC' )->with(['OrderItem' , 'pickupEmp'])->get()->groupBy('pickup_time');
        $orders = Orders::where(['status' => -1])->get();
        return view('admin.confirmation.confirm',compact('orders','pickupBoys','pendingOrders'));
     }
     
    //   public function pending_balance()
    //  {
        
    //     $orders = DB::table('orders')
    //                         ->join('users','orders.pickup_emp','=','users.id')
    //                         ->where('orders.status', '3')
    //                         ->select(DB::raw('orders.pickup_emp,orders.delv_time,SUM(amount) AS pending,users.name,users.mobile'))
    //                         ->orderBy('delv_time', 'ASC')
    //                         ->groupBy('pickup_emp')
    //                         ->groupBy('delv_time')
    //                         ->get();
                            
    //                         // dd($orders);
    //     return view('admin.pending-balance',compact('orders'));


    //  }
     
     public function pending_balance(Request $request)
     {
        if(!empty($request->from_date)){ 
        $delv_date=$request->from_date;}
        else{
        $delv_date=Carbon::now()->toDateString();
        }
        $orders = DB::table('orders')
                            ->join('users','orders.pickup_emp','=','users.id')
                            ->where('orders.status', '3')
                            ->where('orders.final_delivery',$delv_date)
                            ->select(DB::raw('orders.pickup_emp,orders.done_payment,orders.payment_receive_date,orders.delv_time,orders.final_delivery,SUM(orders.after_discount2) AS pending,users.name,users.mobile'))
                            ->orderBy('final_delivery', 'ASC')
                            ->groupBy('pickup_emp')
                            ->groupBy('final_delivery')
                            ->get();
        return view('admin.pending-balance',compact('orders'));


     }

      public function updatepending_balance(Request $request)
     {
         if($request->status== 0 ){
            $status = 1;
        }else{
            $status = 0;
        }
        $date=Carbon::now()->toDateString();
        // dd($date);
        $orders =  Orders::where(['delv_time'=>$request->delv_time,'status'=>'3'])->update(['done_payment'=>$status,'payment_receive_date'=>$date,'updated_at' => false]);
        return back();


     }


     public function accept(Request $request, $id,$status,$mobile,$pickup_emp,$number){


        if($status== -1 ){
            $status = 0;
        }else{
            $status = -1;
        }



        $apiKey = urlencode('OWE2YzVkYmI3NzUxNWUwMjQ1YjhkNWJkZjEyMjhiM2E=');
        // Message details
        $numbers = array($request['mobile']);
        $sender = urlencode('CLNFLD');
        $ordernumber = $request['id'];
        // ARRIVING TODAY%n %nClean Fold's Delivery Agent ( Mbl - 8558989127 ) ll contact you shortly for your order Delivery at your Doorstep.
        $message = rawurlencode("howdy%nYour Order has been confirmed by Cleanfold ,Your order no is $ordernumber Agent name $pickup_emp will contact you shortly for your order Pick-Up at your Doorstep.");
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
          echo$response;


         Orders::where('id',$id)->update(['status'=>$status]);


       return back();
      }



      public function decline(Request $request, $id,$status,$mobile,$pickup_emp,$number,$name){

        if($status== -1 ){
            $status = 4;
        }else{
            $status = -1;
        }

                $apiKey = urlencode('OWE2YzVkYmI3NzUxNWUwMjQ1YjhkNWJkZjEyMjhiM2E=');

                // Message details
                $numbers = array($request['mobile']);
                $sender = urlencode('CLNFLD');
                 $ordernumber = $request['number'];

                 $message = rawurlencode("Dear $name as per your request we have successfully cancelled your order # $ordernumber%nFor further query Call - 9646-222-333 - Clean Fold");
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

         Orders::where('id',$id)->update(['status'=>$status]);
       return back();
      }





}
