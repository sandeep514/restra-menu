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
                    <div>Restuarant Table
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="{{ route('admin.resturant') }}"  class="btn-shadow btn btn-info">
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
                        <div class="card-body"><h5 class="card-title">Resturant Table</h5>
                            <table class="mb-0 table table-bordered data-table" id="products">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>Logo</th>
                                        <th>Email</th>
                                        <th>Barcode</th>
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
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->location }}</td>
                                        <td>{{ App\Models\Country::find($value->country)->name }}</td>
                                        <td>{{ App\Models\State::find($value->state)->name }}</td>
                                        <td> <image src="../images/{{ $value->logo }}" height="70" width="70"></td>
                                        {{-- <td>{{ App\Models\City::find($value->city)->name }}</td> --}}
                                        <td>{{ $value->email }}</td>
                                        <td><img src="{{ $value->barcode }}" alt="barcode" width="70" height="70"/></td>
                                        <td><a href="{{ route('admin.resturant.edit',$value->id) }}" class="btn btn-info" data-info="{{$value->id}}">
                                       <i class="pe-7s-note"> </i></a>
                                                                              
                                         <a href="" onclick="if(confirm('Do you want to delete this detail?'))event.preventDefault(); document.getElementById('delete-{{$value->id}}').submit();" class="btn btn-danger"><i class="pe-7s-trash"> </i></a></a>
                                          <form id="delete-{{$value->id}}" method="post" action="{{ route('admin.resturant.destroy', $value->id)}}" style="display: none;">
                                          @csrf
                                        </form>

                                        <a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-{{$value->id}}').submit();" class="btn btn-danger">
                                           {{ ($value->status == '1') ? 'Active' : 'Deactive' }}

                                        </a>
                                          <form id="status-{{$value->id}}" method="post" action="{{ route('admin.resturant.status',['id'=>$value->id ,'status'=>$value->status])}}" style="display: none;">
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