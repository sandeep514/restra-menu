<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\ProductTypes;
use App\Products;
use App\Orders;
use App\OrderItem;
use App\DiscountCoupon;
use Carbon\Carbon;
use Auth;
use App\User;
use GuzzleHttp\Client;
use Hash;

class ApiController extends Controller
{
	public $orderStatus = [
		0 => 'Order Placed',
		1 => 'Processing Order',
		2 => 'Order Proccessed',
		3 => 'Ready To Deliver',
		4 => 'Delivered'
	];

    public function getCategoriesWithProducts($category_id){
        // dd($category_id);
    	$categoryModel = Categories::find($category_id);
        if($categoryModel->product_types == ''){
            return response()->json(['status'=>false,'message'=>'No product types found']);
        }
    	$selectedProductTypes = ProductTypes::whereIn('id',json_decode($categoryModel->product_types,true))->get();
    	$productsWithCategory = [];
    	foreach($selectedProductTypes as $key => $productType){
    		$productsWithCategory[] = ['product_type_name'=>$productType->type_name,'icon'=>asset('product_type_icons/'.$productType->type_icon),'product_type_id'=>$productType->id,'products'=>Products::where(['categories_id'=>$category_id,'product_type'=>$productType->id,])->orderBy('sort_order','asc')->get()->toArray()];
    	}
    	return response()->json(['status'=>true,'data'=>$productsWithCategory,'hours'=>$categoryModel->hours]);
    }

    public function placeOrder(Request $request){

    	$userDetails = Auth::user();
    	$orderDetails = json_decode($request->order_details,true);
    	$cartDetails = json_decode($orderDetails['cart'],true);
    	$newOrder = new Orders;
        $order_throught='mobile_app';
    	$totalAmount = 0;
        if($orderDetails['order_type'] == 'dont_know'){
            //
        }else{
            foreach($cartDetails as $key => $cart_item) {
                $totalAmount += (int)$cart_item['price'] * (int)$cart_item['qty'];
            }
        }

        if($userDetails->first_order == 0 || $userDetails->first_order == null){
        	User::where(['refer_code'=>$userDetails->invite_code])->increment('wallet_amount',25);
        	$userDetails->first_order = 1;
        	$userDetails->save();
        }
        $isNewuser = false;
        if($orderDetails['mobile'] != $userDetails->mobile){
            $newUser = User::firstOrNew(['mobile'=>$orderDetails['mobile']]);
            $newUser->role_id = 3;
            if(isset($orderDetails['name'])){
                $newUser->name = $orderDetails['name'];
            }else{
                $newUser->name = $userDetails->name;
            }
            $newUser->email = str_random(123).'@gmail.com';
            $newUser->mobile = $orderDetails['mobile'];
            $newUser->password = Hash::make($orderDetails['mobile']);
            $newUser->verify = 1;

            $newUser->otp = 1234;
            $newUser->address = $orderDetails['address'];
            $newUser->save();
            $isNewuser = true;
        }

    	$newOrder->number = rand(1111111111,9999999999);
    	$newOrder->amount = $totalAmount;
    	$newOrder->status = -1;
        $newOrder->order_through='mobile_app';

    	$newOrder->payment_status = 'by_cash';
    	$newOrder->pickup_status = 0;
        $newOrder->pickup_slot = $orderDetails['pick_timeslot'];
        $newOrder->delv_slot = $orderDetails['delv_timeslot'];
        $newOrder->pickup_time = date_format(date_create($orderDetails['pickupTime'])  , 'Y-m-d' );
        $newOrder->delv_time = date_format(date_create($orderDetails['deliveryTime'])  , 'Y-m-d' );
    	$newOrder->address = $orderDetails['address'];
    	$newOrder->mobile = $orderDetails['mobile'];
    	if(isset($orderDetails['order_by'])){
            $newOrder->order_from = $orderDetails['order_by'];
        }
    	if($isNewuser == true){
            $newOrder->user_id = $newUser->id;
        }else{
            $newOrder->user_id = $userDetails->id;
        }

        $newOrder->coupon = $orderDetails['coupon'];
        if(isset($orderDetails['available_cash'])){
        	$newOrder->amount = $totalAmount - $orderDetails['available_cash'];
        	$totalAmount = $newOrder->amount;
        	$userDetails->wallet_amount = 0;
        	$userDetails->save();
        }
        $afterDiscount = 0;
        if($orderDetails['coupon'] != null && $orderDetails['coupon'] != ''){
        	$couponDetails = DiscountCoupon::where(['coupon_code'=>$orderDetails['coupon']])->first();
        	if(Carbon::parse($couponDetails->expiry) >= Carbon::today()){
        		$lessAmount = ($totalAmount * $couponDetails->percent)/100;
        		$afterDiscount = $totalAmount - $lessAmount;
        		$newOrder->after_discount = $afterDiscount;

        	}else{
        		$newOrder->coupon = '';
        	}
        }

        $newOrder->order_type = $orderDetails['order_type'];
        if($orderDetails['order_type'] == 'dont_know'){
        	$newOrder->order_categories = $orderDetails['category'];
    	}
    	$newOrder->save();

        // Save user address
        $userModel = Auth::user();
        $userModel->address = $orderDetails['address'];
        $userModel->save();

        $parsedDate = Carbon::parse($orderDetails['pickupTime']);
        $parsedDelvDate = Carbon::parse($orderDetails['deliveryTime']);
        $productsCategory = [];
        if($orderDetails['order_type'] == 'dont_know'){
            $explodedCategories = explode(',',$orderDetails['category']);
            $productsCategory = $explodedCategories;
        }else{
            foreach($cartDetails as $key => $orderItem){
                $orderItemModel = new OrderItem;
                $orderItemModel->order_id = $newOrder->id;
                $orderItemModel->product_id = $orderItem['id'];
                $orderItemModel->qty = $orderItem['qty'];
                $orderItemModel->price = $orderItem['price'];
                $orderItemModel->total_amount = $totalAmount;
                $orderItemModel->save();
                $productModel = Products::find($orderItem['id']);
                if(!in_array($productModel->categories_id, $productsCategory)){
                    $productsCategory[] = $productModel->categories_id;
                }
            }
        }
        $orderedCategories = Categories::whereIn('id',$productsCategory)->pluck('name','id')->toArray();
        $response = [
                        'status'=>true,
                        'message'=>'Order placed successfully',
                        'order_id'=>$newOrder->id,
                        'amount'=>$totalAmount,
                        'pickup'=>$parsedDate->format('d-m-Y'),
                        'pickup_slot' => $orderDetails['pick_timeslot'],
                        'delv'=>$parsedDelvDate->format('d-m-Y'),
                        'delv_slot' => $orderDetails['delv_timeslot'],
                        'categories'=>$orderedCategories,
                        'order_type' => $orderDetails['order_type'],
                    ];
        if($afterDiscount != 0){
        	$response['amount_to_pay'] = round($afterDiscount);
        }else{
        	$response['amount_to_pay'] = round($totalAmount);
        }
        if(isset($orderDetails['no_pickup'])){
            $response['no_pickup'] = 'true';
        }
        // $client = new Client();
        // $endPoint = 'http://sms.zipzap.in/pushsms.php';
        // $resp = $client->request('GET', $endPoint, ['query' => [
        //     'username' => 'cleanfold',
        //     'api_password' => '32599yi0i8no6ctfk',
        //     'sender' => 'CLNFLD',
        //     'to' => $orderDetails['mobile'],
        //     'message' => 'Your OrderNo:#'.$newOrder->id.' is successfully placed at Clean Fold Our representative will soon be assigned to your order. For any query contact: 9646-222-333',
        //     'priority' => 4
        // ]]);
        // $statusCode = $resp->getStatusCode();
        // $content = $resp->getBody();

        $client = new Client();
        $endPoint = 'https://api.textlocal.in/send';
        $resp = $client->request('GET', $endPoint, ['query' => [
            'apiKey' => 'T0utyqI37r4-6hcm0CCfPX6TUsTJ9lRphdwKUqPBTr',
            'sender' => 'CLNFLD',
            'numbers' => $orderDetails['mobile'],
            //'message' => 'Your OrderNo:#'.$newOrder->id.' is successfully placed at Clean Fold Our representative will soon be assigned to your order. For any query contact: 9646-222-333',
            'message' => 'Your OrderNo:# '.$newOrder->id.' is successfully placed at Clean Fold Our representative will soon be assigned to your order. For any query contact: 9646-222-333',
        ]]);
        $statusCode = $resp->getStatusCode();
        $content = $resp->getBody();
    	return response()->json($response);
    }

    public function userProfile(){
        $userDetails = Auth::user();
        return response()->json(['status'=>true,'user'=>$userDetails->toArray()]);
    }

    public function updateProfile(Request $request){
        $userModel = Auth::user();
        $userModel->name = $request->name;
        $userModel->mobile = $request->mobile;
        $userModel->email = $request->email;
        $userModel->address = $request->address;
        $userModel->save();

        return response()->json(['status'=>true,'message'=>'Profile updated successfully!']);
    }

    public function changePassword(Request $request){
        $userModel = Auth::user();
        if( $request->new_password == $request->conf_password ){
            if( Hash::check( $request->old_password , $userModel->password) ){
                $user = User::where(['api_token' => $request->api_token])->update(['password' => $request->new_password ]);
                return response()->json(['status'=>true,'message'=>'User password created successfully']);
            }else{
                return response()->json(['status'=>false,'message'=>'Wrong old password']);
            }
        }else{
            return response()->json(['status'=>false,'message'=>'New password and confirm password must be same.']);
        }
    }

    public function validateCoupon(Request $request, $coupon){
        $discountModel = DiscountCoupon::where('coupon_code',$coupon)->first();
        if($discountModel == null){
            return response()->json(['status'=>false,'message'=>'Invalid coupon code']);
        }

        $expiryDate = Carbon::parse($discountModel->expiry);
        if(Carbon::now() > $expiryDate){
            return response()->json(['status'=>false,'message'=>'Coupon code has been expired!']);
        }
        return response()->json(['status'=>true,'message'=>'Coupon Applied!','details'=>$discountModel->toArray()]);
    }

    public function verifyOtp(Request $request){
        $userModel = User::where(['mobile'=>$request->mobile])->first();
        if($userModel == null){
            return response()->json(['status'=>false,'message'=>'User not found!']);
        }
        $userModel->verify = 1;
        $userModel->save();
        return response()->json(['status'=>true,'message'=>'User verified successfully!','user'=>$userModel]);
    }


    public function sendOtpForForgetPassword(Request $request){
        $userModel = User::where(['mobile'=>$request->mobile])->first();
        if($userModel == null){
            return response()->json(['status'=>false,'message'=>'User with this mobile number not exists!']);
        }
        $otp = rand(1111,9999);
        $userModel->reset_otp = $otp;
        $userModel->save();

        // $client = new Client();
        // $endPoint = 'http://sms.zipzap.in/pushsms.php';
        // $response = $client->request('GET', $endPoint, ['query' => [
        //     'username' => 'cleanfold',
        //     'api_password' => '32599yi0i8no6ctfk',
        //     'sender' => 'CLNFLD',
        //     'to' => $userModel->mobile,
        //     'message' => 'Your reset OTP is: '.$otp,
        //     'priority' => 4
        // ]]);
        // $statusCode = $response->getStatusCode();
        // $content = $response->getBody();

        $client = new Client();
        $endPoint = 'https://api.textlocal.in/send';
        $response = $client->request('GET', $endPoint, ['query' => [
            'apiKey' => 'T0utyqI37r4-6hcm0CCfPX6TUsTJ9lRphdwKUqPBTr',
            'sender' => 'CLNFLD',
            'numbers' => '91'.$userModel->mobile,
            'message' => 'Your reset OTP is '.$otp,
        ]]);
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();

        return response()->json(['status'=>true,'message'=>'OTP sent successfully!']);
    }

    public function verifyResetOTP(Request $request){
        $userModel = User::where(['mobile'=>$request->mobile,'reset_otp'=>$request->otp])->first();
        if($userModel  == null){
            return response()->json(['status'=>false,'message'=>'Wrong otp entered']);
        }
        return response()->json(['status'=>true,'message'=>'OTP verified successfully!']);
    }

    public function resetPassword(Request $request){
        $userModel = User::where(['mobile'=>$request->mobile,'reset_otp'=>$request->otp])->first();
        if($userModel == null){
            return response()->json(['status'=>false,'message'=>'Wrong details']);
        }
        $userModel->password = Hash::make($request->password);
        $userModel->save();
        return response()->json(['status'=>true,'message'=>'Password updated successfully!']);
    }

    public function getOrders(Request $request)
    {
        $user = Auth::user();
        $usersOrders = Orders::where(['user_id' => $user->id])->orderBy('id' ,'DESC')->get();
        return response()->json(['status' => true , 'message' => 'success' , 'data' => $usersOrders]);
    }

    public function getOrdersDetails(Request $request , $id)
    {
        $usersOrders = Orders::where(['id' => $id])->with(['OrderItem' => function($query){
            return $query->with(['product' => function($query){
                return $query->with(['categories'])->get();
            }])->get();
        }])->first();
        $orderedCategories = [];
        if($usersOrders->order_categories != '' || $usersOrders->order_categories != null){
        	$orderedCategories = Categories::whereIn('id',explode(',',$usersOrders->order_categories))->pluck('name')->toArray();
        }
        $totalQty = [];
        if( $usersOrders['OrderItem'] != null ){
            foreach($usersOrders['OrderItem'] as $k => $v){
                $totalQty[] = $v['qty'];
            }
        }
        if($usersOrders->order_type == 'dont_know'){

        }

        $usersOrders->totalQty = array_sum($totalQty);
        $usersOrders->formated_date = $usersOrders->created_at->format('h:i A / d-m-Y');

        return response()->json(['status' => true , 'message' => 'success' , 'data' => $usersOrders,'order_categories'=>$orderedCategories,'order_type'=>$usersOrders->order_type]);
    }


    public function cancelOrder($order_id){
        $orderDetails = Orders::with(['user'])->find($order_id);
        $orderDetails->status = 4;
        $orderDetails->save();
        // $client = new Client();
        // $endPoint = 'http://sms.zipzap.in/pushsms.php';
        // $resp = $client->request('GET', $endPoint, ['query' => [
        //     'username' => 'cleanfold',
        //     'api_password' => '32599yi0i8no6ctfk',
        //     'sender' => 'CLNFLD',
        //     'to' => $orderDetails->mobile,
        //     'message' => 'Dear '.$orderDetails->user->name.'. As per your request we have successfully cancelled your order #'.$order_id.'. For further query contact 9646-222-333.',
        //     'priority' => 4
        // ]]);
        // $statusCode = $resp->getStatusCode();
        // $content = $resp->getBody();
        $customerName = explode(' ',$orderDetails->user->name);
        $client = new Client();
        $endPoint = 'http://sms.zipzap.in/pushsms.php';
        $resp = $client->request('GET', $endPoint, ['query' => [
            'apiKey' => 'T0utyqI37r4-6hcm0CCfPX6TUsTJ9lRphdwKUqPBTr',
            'sender' => 'CLNFLD',
            'numbers' => $orderDetails->mobile,
            // 'message' => 'Dear '.$orderDetails->user->name.'. As per your request we have successfully cancelled your order #'.$order_id.'. For further query contact 9646-222-333.'
            'message' => 'Dear '.$customerName[0].' As per your request we have successfully canceled your order # '.$order_id.' For further query contact 9646-222-333.'
        ]]);
        $statusCode = $resp->getStatusCode();
        $content = $resp->getBody();
        return response()->json(['status'=>true,'message'=>'Order canceled successfully!']);
    }
}
