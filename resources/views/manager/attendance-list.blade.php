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
                    <div>Attendance List
                    </div>
                </div>

              </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                          @foreach($model as $key)
                          <h5 class="card-title">
                           Employee Name :  {{ ucfirst($key['name']) }}
                          </h5>
                         
                            @php
                            $curentMonth = DateTime::createFromFormat('!m', $attend_month);
                            $month=$curentMonth->format('F')
                            @endphp
                            <h5 class="card-title">
                             Month: {{ $month }}
                          </h5>
                          @endforeach
                            <table class="mb-0 table table-bordered data-table table-sm" id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>Date</th> --}}
                                        <th>In Time</th>
                                        <th>Out Time</th>
                                        <th>Duration</th>

                                    </tr>
                                  </thead>
                                 <tbody>
                                    @php
                                    $i=1;
                                    @endphp
                                    @foreach($model as $keys)
                                    @foreach($keys['atend_all'] as $k)
                                    <tr>
                                      @if($k['attend_month']==$attend_month)
                                      <td>{{ $i++ }}</td>
                                      {{-- <td>{{ $k['attend_date'] }}</td> --}}
                                      <td>{{ \Carbon\Carbon::parse($k['time_start'])->format('d-M-Y H:i') }}</td>
                                      @if(!empty($k['time_end']))
                                      <td>{{ \Carbon\Carbon::parse($k['time_end'])->format('d-M-Y H:i') }}</td>
                                      @else
                                      <td></td>
                                      @endif
                                      <td>{{ $k['duration'] }}</td>
                                      @endif
                                    </tr>
                                @endforeach
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
         $('#in_timemodal').modal('show');
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