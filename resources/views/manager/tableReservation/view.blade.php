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
                    <div>Table List
                    </div> 
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="{{ route('menu.addtable') }}"  class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-business-time fa-w-20"></i>
                        </span>
                        Add
                        </a>                        
                    </div>
                </div>    </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body"><h5 class="card-title">Table List</h5>
                            <table class="mb-0 table table-bordered data-table" id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Table number</th>                                        
                                        <th>Capacity</th>
                                        <th>Status</th>
                                        <th>Booking Status</th>
                                        <th>Qrcode</th>
                                        <th>Action</th>
                                    </tr>
                                  </thead>
                                 <tbody>
                                    @php
                                    $i=1;
                                    @endphp
                                    @foreach($model as $key => $value)
                                    <tr>
                                        <th scope="row">{{ $i++ }}</th>
                                        <td>{{ $value->table_number }}</td>
                                        <td>{{ $value->capacity }}</td>
                                        <td> <a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-{{$value->id}}').submit();" class="btn btn-sm btn-{{ ($value->status == '1') ? 'danger' : 'success'  }}">
                                           {{ ($value->status == '1') ? 'Inactive' : 'Active'   }}

                                        </a></td>
                                         <td>
                                          
                                          <form method="post" action="{{ route('menu.tablebook.status') }}" id="bstatus{{ $value->id }}">
                                            <input type="hidden" name="id" value="{{$value->id}}">
                                            @csrf
                                             <select class=" form-control bookingstatus " name="booking_status" id="booking_status" data-value="{{$value->id}}" onchange="document.getElementById('bstatus{{$value->id}}').submit();">
                                                           <option >Booking status</option>
                                                           <option value="0"  {{ ($value->booking_status == '0') ? 'selected' : ''   }}>Reserved</option>
                                                           <option value="1"  {{ ($value->booking_status == '1') ? 'selected' : ''   }}>Available</option>
                                                           <option value="2"  {{ ($value->booking_status == '2') ? 'selected' : ''   }}>Damage</option>
                                                    </select>
                                                </form>
                                        </td>
                                           <td><img src="{{ $value->qrcode }}" alt="barcode" width="70" height="70"/></td>
                                        <td><a href="{{ route('menu.table.edit',$value->id) }}" class="edit" data-info="{{$value->id}}"><i class="pe-7s-note"> </i></a>
                                                                              
                                         <a href="" onclick="if(confirm('Do you want to delete this detail?'))event.preventDefault(); document.getElementById('delete-{{$value->id}}').submit();" class="delete"><i class="pe-7s-trash"> </i></a>
                                          <form id="delete-{{$value->id}}" method="post" action="{{ route('menu.table.destroy', $value->id)}}" style="display: none;">
                                          @csrf
                                        </form>

                                       
                                          <form id="status-{{$value->id}}" method="post" action="{{ route('menu.table.status',['id'=>$value->id ,'status'=>$value->status])}}" style="display: none;">
                                          @csrf
                                        </form>
                                       
                                    </td>
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