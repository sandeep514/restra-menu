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
                    <div>Menu Table
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                       
                        <a href="{{ route('menu.addmenu') }}"  class="btn-shadow btn btn-info">
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
                        <div class="card-body" style=""><h5 class="card-title">Menu Table</h5>
                             <div class="table-responsive">
                            <table class="table table-bordered " id="example" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Today's Special</th>
                                        <th>Best Seller</th>
                                        <th>Category</th>
                                        <th>Sub</th>
                                        <th>Image</th>
                                        <th>Item</th>
                                        <th>Type</th>
                                        <th>₹</th>
                                        <th>Discount</th>
                                        <th width="30%">Description</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead> 
                                 <tbody>
                                    @php
                                    $i=1;
                                    @endphp
                                    @foreach($model as $key => $value)
                                    <tr>
                                        @if(!empty($model))
                                        <th scope="row">{{ $i++ }}</th>
                                        
                                        {{-- <form id="chef-{{$value->id}}" method="post" action="">
                                          @csrf
                                          <div class="position-relative form-check">
                                                        <input type="checkbox" class="form-check-input" value="1" name="chef_status[]">
                                            </div>
                                        </form> --}}
                                        <td> <a href="javascript:void(0)" onclick="document.getElementById('specialstatus-{{$value->id}}').submit();" class="btn btn-sm ">
                                          
                                           @if(($value['chef_special'] == '1'))
                                           <input type="checkbox" checked/>
                                           @else
                                          <input type="checkbox" />
                                          @endif

                                           

                                        </a>
                                          <form id="specialstatus-{{$value->id}}" method="post" action="{{ route('menu.specialstatus',['id'=>$value->id ,'status'=>$value->chef_special])}}" style="display: none;">
                                          @csrf
                                        </form></td>

                                        <td> <a href="javascript:void(0)" onclick="document.getElementById('sellerstatus-{{$value->id}}').submit();" class="btn btn-sm ">
                                          
                                           @if(($value['best_seller'] == '1'))
                                           <input type="checkbox" checked/>
                                           @else
                                          <input type="checkbox" />
                                          @endif

                                           

                                        </a>
                                          <form id="sellerstatus-{{$value->id}}" method="post" action="{{ route('menu.sellerstatus',['id'=>$value->id ,'status'=>$value->best_seller])}}" style="display: none;">
                                          @csrf
                                        </form></td>

                                        <td>{{ App\Models\Categories::find($value->category_id)->dish_category}}</td>
                                        <td>{{ App\Models\Subcategories::find($value->subcategory_id)->dish_subcategory}}</td>
                                        @if(!empty($value->image))
                                        <td><img src="../category/{{ $value->image }}" height="70" width="70"></td>
                                        @else    
                                        <td><img src="../category/no.png" height="70" width="70"></td>
                                        @endif                                            
                                         <td>{{ $value->menu_name }}</td>

                                        
                                        <td> <a href="javascript:void(0)" onclick="document.getElementById('fstatus-{{$value->id}}').submit();" class="btn btn-sm btn-{{ ($value['foodstatus'] == '1') ? 'success' : 'danger' }}">
                                           {{ ($value['foodstatus'] == '1') ? 'Veg' : 'Non-Veg ' }}

                                        </a>
                                          <form id="fstatus-{{$value->id}}" method="post" action="{{ route('menu.foodstatus',['id'=>$value->id ,'status'=>$value->foodstatus])}}" style="display: none;">
                                          @csrf
                                        </form></td>
                                        <td>{{ $value->price }}</td>
                                        <td>{{ $value->discount }}</td>
                                        <td data-toggle="tooltip"
                                                    data-placement="left" title="{{ $value->description}}"> {{ Illuminate\Support\Str::limit($value->description, 25, '...') }} </td>
                                        <td>
                                             @for( $j = 1 ; $j <= $value->rating; $j++ )
                                                    <i class="fa fa-star text-warning" style="font-size:10px;"></i>
                                                @endfor
                                        </td>
                                        <td> <a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-{{$value->id}}').submit();" class="btn btn-sm btn-{{ ($value['status'] == '1') ? 'danger' : 'success' }}">
                                           {{ ($value['status'] == '1') ? 'Inactive' : 'Active' }}

                                        </a>
                                          <form id="status-{{$value->id}}" method="post" action="{{ route('menu.status',['id'=>$value->id ,'status'=>$value->status])}}" style="display: none;">
                                          @csrf
                                        </form></td>
                                        {{-- <td> {{ ($value->status == '1') ? 'Active' : 'Deactive' }}</td> --}}
                                        <td><a href="{{ route('menu.edit',$value->id) }}" class="edit" data-info="{{$value->id}}">
                                        <i class="pe-7s-note"> </i></a>
                                                                              
                                         <a href="" onclick="if(confirm('Do you want to delete this detail?'))event.preventDefault(); document.getElementById('delete-{{$value->id}}').submit();" class="delete"><i class="pe-7s-trash"> </i></a>
                                          <form id="delete-{{$value->id}}" method="post" action="{{ route('menu.destroy', $value->id)}}" style="display: none;">
                                          @csrf
                                        </form>

                                       
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                               {{ __('Logout') }}
                            </a>
                             <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                                        @csrf
                                    </form>

                                   
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection
     @section('script')
    <script>
        $(document).ready(function () {
             $('#example').dataTable({
                 "autoWidth":false,
                 "columnDefs": [ { "width": "30px", "targets": 5 }],
             });

             
        });
    @endsection