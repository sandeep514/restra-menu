<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Restuarant_list,User};
use App\Models\TableBooking;

class TableController extends Controller
{
         public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {   // dd(auth()->user()->role_id);
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $model = TableBooking::orderBy('id', 'asc')->where('restra_id',$id)->get();
        
        return view('manager.tabledetail.view', ['model' => $model]);
    }

    public function tableAdd()
    {
        return view('manager.tabledetail.create');
    }

    public function tableStore(Request $request)
    {   

        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $detail = TableBooking::where('restra_id', $id)->where('table_number',$request['table_number'])->get();
        if(count($detail)>0)
        {
            return redirect()->back()
            ->withErrors('Already exists');    
        }else{
        $request->validate([
            'table_number'=>'required|integer',
            'capacity' =>  'required|integer',
        ]);
      }
        $input=$request->all();
        $input['restra_id']=$id;
        $table_info = TableBooking::create($input);
        $restra_id=$id;
        $bar_id=$table_info->id;
        $link="http://127.0.0.1:8000/restra/";
        $url="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=";
       
         $qrcode=$url.$link.$restra_id.'/'.$bar_id.'/';
         $update=TableBooking::where('id',$bar_id)->update(['qrcode'=>$qrcode]);
        return redirect()->back()
            ->with('success', 'created successfully.');
        }  

    public function tabledestroy($id)
    {
        $detail = TableBooking::find($id);
        $detail->delete();
        return redirect()->back()->with('success', 'table deleted');
    }

    public function tablestatus($id, $status)
    {   
        if($status== '1' ){
            $status = '0';
        }else{  
            $status = '1';
        }
        $detail = TableBooking::where('id', $id)->update(['status' => $status]);
        return redirect()->back()->with('success', 'Status changed');
    }

    public function tableReservestatus(Request $request)
    {          
        $detail = TableBooking::where('id', $request->id)->update(['booking_status' => $request->booking_status]);
        return redirect()->back()->with('success', 'Status changed');
    }

    public function tableEdit($id)
    {
        $detail = TableBooking::find($id);
        return view('manager.tabledetail.edit', compact('detail'));
    }

    public function edittable(Request $request, $id)
    { 
        $log_id=auth()->user()->id;
        $ids=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $request->validate([
               'capacity' =>  'required|integer',
        ]);
        $tablesbook = TableBooking::findOrFail($id);
        $tablesbook->update($request->all());

        return redirect()
            ->route('menu.tableview')
            ->with('success', 'updated');
    }

     public function seatView()
    {   // dd(auth()->user()->role_id);
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->where('status','1')->pluck('id')->first();
        $model = TableBooking::orderBy('id', 'asc')->where('restra_id',$id)->get();
        
        return view('manager.tableReserveView.view', ['model' => $model]);
    }   
}
