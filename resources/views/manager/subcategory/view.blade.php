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
                     <div>Subcategory Table
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="{{ route('menu.addsubcategory') }}"  class="btn-shadow btn btn-info">
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
                        <div class="card-body"><h5 class="card-title">SubCategory Table</h5>
                            <table class="mb-0 table table-bordered data-table" id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Dish Subcategory</th>
                                        <th>Type</th>
                                        <th>Image</th>
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
                                        <td>{{ ucfirst(App\Models\Categories::find($value->category_id)->dish_category)}}</td>
                                         <td>{{ ucfirst($value->dish_subcategory) }}</td>
                                        <td>{{ ($value->dish_type =='1') ? 'Vegetarian' : 'Non Vegetarian' }}</td>
                                         <td><img src="../category/{{ $value->image }}" height="70" width="70"></td>
                                        <td><a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-{{$value->id}}').submit();" class="btn btn-sm  btn-{{ ($value->status == '1') ? 'danger' : 'success' }}">
                                           {{ ($value->status == '1') ? 'Deactive' : 'Active' }}

                                        </a>
                                          <form id="status-{{$value->id}}" method="post" action="{{ route('menu.subcategory.status',['id'=>$value->id ,'status'=>$value->status])}}" style="display: none;">
                                          @csrf
                                        </form> </td>


                                       
                                        <td><a href="{{ route('menu.subcategory.edit',$value->id) }}" data-info="{{$value->id}}" class="edit"><i class="pe-7s-note"> </i></a>
                                                                              
                                         <a href="" onclick="if(confirm('Do you want to delete this detail?'))event.preventDefault(); document.getElementById('delete-{{$value->id}}').submit();" class="delete"><i class="pe-7s-trash"> </i></a>
                                          <form id="delete-{{$value->id}}" method="post" action="{{ route('menu.subcategory.destroy', $value->id)}}" style="display: none;">
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
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-left">
                 
                </div>
            </div>
        </div>
    </div>
    @endsection