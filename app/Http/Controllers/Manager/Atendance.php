<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Country, State, City,Restuarant_list,User,Categories};
use App\Models\Employee;
use App\Models\Role;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 
use Carbon\CarbonPeriod;


class Atendance extends Controller
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
        $log_id=auth()->user()->id;
        $id=Restuarant_list::where('user_id', $log_id)->pluck('id')->first();
        $data['role']=Role::get();
        $data['model'] = Employee::with('attend')->latest()->where("role_id",'>','2')->where("parent_id",$id)->get()->toArray();
        return view('manager.dashboard', $data);
    }

     public function intime(Request $request)
    {   
       $input=$request->all();
       $explode=explode('-',$input['time_start']);
       $input['attend_month']= $explode[1];
       $input['attend_year']= $explode[0];
       Attendance::create($input);
       return redirect()->back()
            ->with('success', 'created successfully.');

    }

    public function outtime(Request $request)
    {   
       $condition=Attendance::where('employ_id',$request['employ_id'])->where('punch','in')->latest()->pluck('id','time_start');
       foreach ($condition as $key=>$value) {

        $endTime = explode('T',$request['time_end']);
        $endDTime = \Carbon\Carbon::parse($endTime[0].' '.$endTime[1]);
        $startTime = explode('T',$key);
        $startDTime = \Carbon\Carbon::parse($startTime[0].' '.$startTime[1]);
        $diff = $endDTime->diff($startDTime)->format('%H.%I');
       }
       $detail=Attendance::where('employ_id',$request['employ_id'])->where('id',$value)->update(['time_end' => $request['time_end'],'punch'=>$request['punch'],'duration'=>$diff]);

       return redirect()->back()
            ->with('success', 'successfully.');

    }

    public function viewAttendanceAll($id){
        $list = Employee::where("role_id",'>','2')->where("id",$id)->with('atend_all')->first();
        $model = DB::table('attendance')
                            ->where('employ_id', $id)
                            ->select(DB::raw('COUNT(*) as totaltime, attend_month,attend_year, employ_id, duration, SUM(duration) AS total_duration'))
                            ->groupBy('attend_year')
                            ->groupBy('attend_month')
                            ->get();
         return view('manager.attendance-all',['model' => $model,'list'=>$list]);   
     
    }

    public function viewAttendance($id,$month){
        $model = Employee::with('atend_all')->where("role_id",'>','2')->where("id",$id)->get()->toArray();
        // dd($data);
         return view('manager.attendance-list',['model'=>$model,'attend_month'=>$month]);   
    }
}
