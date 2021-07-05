<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Categories;
use App\Products;
use App\Orders;
use App\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Auth;
use Validator;
use App\Http\Controllers\Admin\OrdersController;
use GuzzleHttp\Client;
use Session;
use App\Locality;


class UsersController extends Controller
{


    public function apiResponse(Request $request){
        $class = "App\\".ucfirst($request->model);
        $results = QueryBuilder::for($class)
            ->allowedFilters('id')
            ->get();
        return response()->json(['status'=>true,'results'=>$results]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile_email' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->toArray(),'status'=>false],200);
        }
        $byMobileOrEmail = User::where(['email'=>$request->mobile_email])->orWhere(['mobile'=>$request->mobile_email])->where(['verify'=>1])->first();
        if($byMobileOrEmail == null){
            return response()->json(['errors'=>'Wrong user details or user not verify','status'=>false],200);
        }else{
            if(Hash::check($request->password,$byMobileOrEmail->password)){
                return response()->json(['status'=>true,'details'=>$byMobileOrEmail],200);
            }else{
                return response()->json(['errors'=>'Wrong user details','status'=>false],200);
            }
        }
    }


    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'email' => 'required|email|unique:users',
            'password' => 'required',
            // 'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'mobile' => 'required|min:10|digits:10|numeric',
            // 'mobile' => 'required|min:10|digits:10|numeric|unique:users',
        ],['password.regex'=>'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character']);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->toArray(),'status'=>false],200);
        }

        if($request->has('invite_code') && $request->invite_code != null && $request->invite_code != 'undefined'){
            $validateReferalCode = User::where(['refer_code'=>$request->invite_code])->first();
            if($validateReferalCode == null){
                return response()->json(['errors'=>[['Invalid referal code']],'status'=>false],200);
            }
        }
        $otp = rand(1111,9999);
        $userModel = User::firstOrNew(['mobile'=>$request->mobile]);
        $userModel->name = $request->name;
        $userModel->email = str_random().'@gmail.com';
        $userModel->password = Hash::make($request->password);
        $userModel->api_token = Hash::make(str_random());
        $userModel->mobile = $request->mobile;
        $userModel->otp = $otp;
        $userModel->refer_code = substr($request->name, 0, 3).''.substr($request->mobile, -4);
        $userModel->role_id = 3;
        if($request->has('invite_code') && $request->invite_code != null && $request->invite_code != 'undefined'){
            $userModel->invite_code = $request->invite_code;
            $userModel->wallet_amount = 25;
        }
        $userModel->save();

        // $client = new Client();
        // $endPoint = 'http://sms.zipzap.in/pushsms.php';
        // $response = $client->request('GET', $endPoint, ['query' => [
        //     'username' => 'cleanfold',
        //     'api_password' => '32599yi0i8no6ctfk',
        //     'sender' => 'CLNFLD',
        //     'to' => $userModel->mobile,
        //     'message' => 'OTP for Clean Fold is: '.$otp,
        //     'priority' => 4
        // ]]);
        // $statusCode = $response->getStatusCode();
        // $content = $response->getBody();

        $client = new Client();
        $endPoint = 'https://api.textlocal.in/send';
        $resp = $client->request('GET', $endPoint, ['query' => [
            'apiKey' => 'T0utyqI37r4-6hcm0CCfPX6TUsTJ9lRphdwKUqPBTr',
            'sender' => 'CLNFLD',
            'numbers' => $userModel->mobile,
            'message' => 'OTP for Clean Fold is: '.$otp
        ]]);
        $statusCode = $resp->getStatusCode();
        $content = $resp->getBody();

        return response()->json(['message'=>'User created success!','status'=>true,'token'=>$userModel->api_token],200);
    }

    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show a page of user creation
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Insert new user into the system
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['api_token'] = str_random();
        $input['email'] = str_random().'@gmail.com';
        $input['otp'] = rand(1111,9999);
        $input['invite_code'] = $request->name.rand(111,999);
        $user = User::create($input);

        return redirect()->route('users.index')->withMessage(trans('coreadmin::admin.users-controller-successfully_created'));
    }

    /**
     * Show a user edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::pluck('title', 'id');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update our user information
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user->update($input);

        return redirect()->route('users.index')->withMessage(trans('coreadmin::admin.users-controller-successfully_updated'));
    }

    /**
     * Destroy specific user
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        User::destroy($id);

        return redirect()->route('users.index')->withMessage(trans('coreadmin::admin.users-controller-successfully_deleted'));
    }


    public function notConfirmedUser(){
        $users = User::where(['verify'=>0])->get();
        return view('admin.users.not-confirmed',['users'=>$users]);
    }

    public function adminCreateUser(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',

        ]);

        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email'  => $request->name.'_'.$request->mobile.'@gmail.com',
            'verify' => 1,
            'role_id' => 3,
            'password' => Hash::make( $this->generateRandomString(10) ),
            'otp' => 0000,
        ]);
        if( $user ){
            return response()->json( ['error' => false , 'data' => 'user added successfully' ] );
        }else{
            return response()->json(['error' => true , 'data' => 'something went wrong.']);
        }
    }

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getUserDetails($mobileNumber)
    {
        $user = User::where('mobile' ,'like', '%'.$mobileNumber.'%')->get();
        return response()->json(['error' => null , 'data' => $user]);
    }

    public function listUserDetails()
    {
        $user = User::select('name' , 'id')->get();
        return response()->json(['error' => null , 'data' => $user]);
    }

    public function userDetails($userId)
    {
        $user = User::whereId($userId)->first();
        return response()->json(['error' => null  , 'data' => $user]);
    }

    public function sendSMS(Request $request)
    {
        // dd($request);
        // Account details
        $apiKey = urlencode('OWE2YzVkYmI3NzUxNWUwMjQ1YjhkNWJkZjEyMjhiM2E=');

        // Message details
        $numbers = array($request['mobile']);
        $sender = urlencode('CLNFLD');
        // $ordernumber = $request['number'];
        $ordernumber = $request['order_id'];
        $message = rawurlencode("Your OrderNo:# $ordernumber is successfully placed at Clean Fold Our representative will soon be assigned to your order. Query Call - 9646-222-333 - Clean Fold");
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

    }

    public function createUserAddress(Request $request)
    {
        if($request->msg == null){
        $selectedProducts = $request->product;
        $products = null;
        $price = 0;


        if(!empty($request['new_loc_name'])){

            $newloc = new Locality;
            $newloc->area_name = $request->new_loc_name;
            $newloc->save();

            $request['id_location'] = $newloc->id;

        }
        if(!empty($request['new_user_name'])){

            $newUser  = new User;
             $newUser->name   = $request->new_user_name;
             $newUser->mobile = $request->mobile;
             $newUser->email = $request->new_user_name.'@gmail.com';
             $newUser->verify = 1;
             $newUser->role_id = 3;
             $newUser->password = Hash::make($request->mobile);
             $newUser->otp = 0000;
             $newUser->save();

            //  $newUser->id;

        }

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
            "city"          => 'required',
            "pincode"       => 'required|integer',
            "State"         => 'required',
            'pickup_time'   => 'required',
            'delv_time'     => 'required',
            'address'       => 'required',
            'pickupboy'     => 'required'
        ]);

         $locs = Locality::where( 'id',$request->id_location)->first();

        User::where('mobile' , $request->mobile)->update([
            'address' => $request->Hno.','.$request->street.','.$locs->area_name.','.$request->city.','.$request->pincode.','.$request->State,
            'Hno' => $request->Hno,
            'street' => $request->street,
            'id_location' => $request['id_location'],
            'city' => $request->city,
            'pincode' => $request->pincode,
            'State' => $request->State
        ]);

        $user = User::where(['mobile' => $request->mobile])->first();

        $orders = Orders::create([
            'number'            => $request->number,
            'order_categories'  => $request->category,
            'status'            => 0,
            'payment_status'    => 'by_cash',
            'pickup_status'     => 0,
            'pickup_time'       => $request->pickup_time,
            'delv_time'         => $request->delv_time,
            'pickup_emp'         => $request->pickupboy,
            'address'           => $request->address,
            'mobile'            => $request->mobile,
            'remarks'           =>$request->remarks,
            'user_id'           => $user->id,
            'order_type'        => 'normal',
            'amount'            => $price,
            'order_through'     =>'administration',
            'id_location'       => $request['id_location']
        ]);
        $orderId = $orders->id;
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
        $input=$request;
        $input['order_id']=$orders->id;
         $this->sendSMS($input);


        Session::flash('success' , 'Order created successfully');
		return redirect()->route(config('coreadmin.route').'.orders.index');
    }
    elseif($request->msg == 1)
    {
        //  dd($request->toArray());
        $selectedProducts = $request->product;
        $products = null;
        $price = 0;


        if(!empty($request['new_loc_name'])){

            $newloc = new Locality;
            $newloc->area_name = $request->new_loc_name;
            $newloc->save();

            $request['id_location'] = $newloc->id;

        }
        if(!empty($request['new_user_name'])){

            $newUser  = new User;
             $newUser->name   = $request->new_user_name;
             $newUser->mobile = $request->mobile;
             $newUser->email = $request->new_user_name.'@gmail.com';
             $newUser->verify = 1;
             $newUser->role_id = 3;
             $newUser->password = Hash::make($request->mobile);
             $newUser->otp = 0000;
             $newUser->save();

            //  $newUser->id;

        }

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
            "city"          => 'required',
            "pincode"       => 'required|integer',
            "State"         => 'required',
            'pickup_time'   => 'required',
            'delv_time'     => 'required',
            'address'       =>'required',
            'pickupboy'     => 'required'
        ]);

        User::where('mobile' , $request->mobile)->update([
            'address' => $request->Hno.','.$request->street.','.$request->id_location.','.$request->city.','.$request->pincode.','.$request->State,
            'Hno' => $request->Hno,
            'street' => $request->street,
            'locality' => $request->locality,
            'id_location' => $request['id_location'],
            'city' => $request->city,
            'pincode' => $request->pincode,
            'State' => $request->State
        ]);

        $user = User::where(['mobile' => $request->mobile])->first();


        $orders = Orders::create([
            'number'            => $request->number,
            'order_categories'  => $request->category,
            'status'            => 0,
            'payment_status'    => 'by_cash',
            'pickup_status'     => 0,
            'pickup_time'       => $request->pickup_time,
            'delv_time'         => $request->delv_time,
            'pickup_emp'         => $request->pickupboy,
            'address'           => $request->address,
            'mobile'            => $request->mobile,
            'remarks'           =>$request->remarks,
            'user_id'           => $user->id,
            'order_type'        => 'normal',
            'amount'            => $price,
            'order_through'     =>'administration',
            'id_location'       => $request['id_location']
        ]);
        $orderId = $orders->id;
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

        Session::flash('success' , 'Order created successfully');
		return redirect()->route(config('coreadmin.route').'.orders.index');



    }else{
		return redirect()->route(config('coreadmin.route').'.orders.index');


    }

    }

    public function getCategoryProducts($id , $catId=null)
    {
            if(empty($catId)){
                $catId =$id;
            }

        // $category = categories::whereId($catId)->first();
        // $categoryProduct_types = $category->product_types;

        // $arrayProductType = json_decode($categoryProduct_types);

        $productType = Products::where( 'categories_id' , $catId )->orderBy('title' , 'ASC')->get();
        if( $productType->count() > 0 ){
            $listProductType = $productType->toArray();
        }
        else
        {

            $listProductType = [];
        }
        return response()->json([ 'error' => null , 'data' => $listProductType ]);
    }

    public function listEmployee()
    {
        $roleIds = [4,5,6];
        $users = User::whereIn('role_id' , $roleIds)->with(['role'])->get();
        return view('admin.users.listEmployee' , compact('users'));
    }
    public function changeUserStatus($userId)
    {

        $userDetails = User::whereId($userId)->first();
        if( $userDetails->status == 1 ){
            User::whereId($userId)->update(['status' => 0]);
        }else{
            User::whereId($userId)->update(['status' => 1]);
        }
        return back();
    }




}
