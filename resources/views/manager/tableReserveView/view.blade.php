@extends('layouts.app1')
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Seat View
                    </div> 
                </div>               
               </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                          <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                   <div class="badge badge-reserve ml-2">Reserved</div>
                                    <div class="badge bagde-available ml-2">Available</div>
                                    <div class="badge badge-light ml-2">Damage</div>
                                </div>
                            </div>
                        <div class="card-body"><h5 class="card-title">Seat View</h5>
                        <div class="row">
                           @foreach($model as $key => $value)
                           @php
                           if($value->booking_status=='1')
                           {
                            $bookingstatus='a';
                           }
                           elseif($value->booking_status=='2')
                           {
                             $bookingstatus='d';
                           }
                           else{
                             $bookingstatus='i';
                           }
                           @endphp 
                                        <div class="col-md-2">
                                        @if($value->capacity=='4')

                                        <img src="../table_icon/4C{{ $bookingstatus }}.png" height="70" width="70">
                                        @endif
                                         @if($value->capacity=='6')
                                         <img src="../table_icon/6C{{ $bookingstatus }}.png" height="70" width="70">
                                        @endif
                                        <div class="text-block">
                                            
                                            <span>Table No.{{ $value->table_number }}</span>
                                          </div>
                                      </div>
                                        
                                @endforeach
                            </div></div>
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
     @section('script')
{{--     <script>
        $(document).ready(function () {

            $('#booking_status').on('change', function () {
                var statustable = this.value;
                var id = $(this).data('value');
                $.ajax({
                 url : '{{ route('menu.tablebook.status')}}',
                 method : 'post',
                 data :  { 'id' : id , 'status' : statustable , '_token': '{{csrf_token()}}' },
                 success: function(res){
                     if( res.status == 'true'){
                         location.reload();
                     }else{
                         alert("Something went wrong.");
                     }
                 },
                 error : function(err){
                     console.log(err);
                     alert("Something went wrong.");
                 }
                })
                
            });
        });

    </script> --}}
    @endsection