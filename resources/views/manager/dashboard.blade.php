@extends('layouts.app1')
@section('content')
<style>
    a.disabled {
  pointer-events: none;
  cursor: default;
}
</style>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Attendance Table
                    </div>
                  {{--   @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif --}}
                </div>

              </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body"><h5 class="card-title">Attendance Table</h5>
                            <table class="mb-0 table table-bordered data-table" id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Designation</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>In/Out Time</th>
                                        <th>Duration</th>
                                        <th>Attendance</th>

                                    </tr>
                                  </thead>
                                 <tbody>
                                    @php
                                    $i=1;
                                    $j=0;
                                    @endphp
                                    @foreach($model as $key)
                                    <tr>
                                        <th scope="row">{{ $i++ }}</th>
                                        <td>{{ ucfirst($key['name']) }}</td>
                                        <td>{{ $key['email'] }}</td>
                                       
                                        @foreach($role as $keys=>$values)
                                        @if($values->id==$key['role_id'])
                                        
                                        <td>{{ ucfirst($values->name)}}</td>
                                        @endif
                                        @endforeach


                                        <td> <a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-{{$key['id']}}').submit();" class="btn btn-sm btn-{{ ($key['status'] == '1') ? 'danger' : 'success' }}">
                                           {{ ($key['status'] == '1') ? 'Deactive' : 'Active' }}

                                        </a>
                                          <form id="status-{{$key['id']}}" method="post" action="{{ route('menu.employee.status',['id'=>$key['id'] ,'status'=>$key['status']])}}" style="display: none;">
                                          @csrf
                                        </form></td>

                                       @if(!empty($key['attend']))                                    
                                       @php 
                                      if(!empty($key['attend']['time_end'])){
                                        $endTime = explode('T',$key['attend']['time_end']);
                                        $endDTime = \Carbon\Carbon::parse($endTime[0].' '.$endTime[1]);
                                       }
                                       else{
                                        $endDTime = \Carbon\Carbon::now();
                                        }

                                        // $startTime = explode('T',$key['attend']['time_start']);
                                       

                                       @endphp
                                        <td><span>
                                         @php
                                         $curDate=\Carbon\Carbon::now()->format('Y-m-d');
                                         if($key['attend']['attend_date']  == $curDate){
                                              echo $key['attend']['attend_date'] ;
                                        $startDTime = \Carbon\Carbon::parse($key['attend']['time_start']);
                                        $totalDuration = $endDTime->diff($startDTime)->format('%H.%I');

                                         }
                                         else
                                         {
                                         echo $curDate;

                                        $totalDuration = 00.00;
                                         }
                                         @endphp       
                                        </span></td>
                                        <td>    
                                        @if($key['attend']['punch']=='in')
                                        <a href="javascript:void(0)" onclick="exit_time({{ $key['id'] }})" data-info="{{$key['id']}}" class="btn btn-sm btn-info" id="out_time{{ $key['id'] }}">Out time</a>
                                        @else
                                        <a href="javascript:void(0)" onclick="enter_time({{ $key['id'] }})" id="in_time{{ $key['id'] }}" data-info="{{$key['id']}}" class="btn btn-sm btn-info">In time</a>
                                        @endif
                                      </td>
                                      <td>{{ (empty($key['attend']['duration']) ? $totalDuration : $key['attend']['duration'] )}}</td>
                                      @else
                                      <td><span>{{ \Carbon\Carbon::today()->format('Y-m-d') }}</span></td>
                                      <td><a href="javascript:void(0)" onclick="enter_time({{ $key['id'] }})" id="in_time{{ $key['id'] }}" data-info="{{$key['id']}}" class="btn btn-sm btn-info">In time</a>
                                        </td>
                                        <td></td>
                                      @endif
                                    <td> <a href="{{ route('employee.all.attend',['id'=>$key['id']])}}" class="btn btn-sm">View</a></td>
                                    {{-- <td> <a href="{{ route('employee.attend',['id'=>$key['id']])}}" class="btn btn-sm">View</a></td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>


    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-left">
                 
                </div>
            </div>
        </div>
    </div>
  
    @endsection
     @section('modal')
       <div class="modal fade" id="in_timemodal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="in-time">In time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employee.intime') }}"  method="POST">
                     @csrf
            <div class="modal-body">
                
                    <input type="hidden" name="employ_id" value="">
                    <input type="hidden" name="punch" value="in">
                    
                     <div class="position-relative row form-group">
                <label for="time_start" class="col-sm-3 col-form-label">In time</label>
                <div class="col-sm-8">
                    <input name="time_start" type="datetime-local" class="form-control"  value={{ \Carbon\Carbon::now()}} required>
                </div>
            </div> 
            
                   <input type="hidden" name="attend_date"  class="form-control" value={{ \Carbon\Carbon::today() }} readonly />
            

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
                 </form>   
        </div>
    </div>
</div>
 <div class="modal fade" id="out_timemodal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="out-time">Out time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form action="{{ route('employee.outtime') }}"  method="POST">

             @method('PUT')
                @csrf
            <div class="modal-body">               
                     
                     <input type="hidden" name="employ_id" value="" >
                     <input type="hidden" name="punch" value="out">
                     <div class="position-relative row form-group">
                <label for="time_end" class="col-sm-3 col-form-label">Out time</label>
                <div class="col-sm-8">
                    <input name="time_end"  type="datetime-local" class="form-control"  value={{ \Carbon\Carbon::now()}} required>
                </div>
            </div> 
                   <input type="hidden" name="attend_date"  class="form-control" value={{ \Carbon\Carbon::today() }} readonly>
                 

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
</form>
        </div>
    </div>
</div>
@endsection



     @section('script')
     <script type="text/javascript">
        function enter_time($id){

         $('#in_timemodal').modal();
         $('#in_time'+$id).data('info');
         $('input[name=employ_id]').val($id);

       }

        function exit_time($id){
         $('#out_timemodal').modal('show');
         $('#out_time'+$id).data('info');
        $('input[name=employ_id]').val($id);
       }
     $(document).ready(function () {

    });
</script>
@endsection