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
                    <div>Employee Table
                    </div>
                  {{--   @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif --}}
                </div>

                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="{{ route('menu.addemployee') }}"  class="btn-shadow btn btn-info">
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
                        <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                    <div class="badge badge-warning ml-2">Left Job</div>
                                    <div class="badge badge-light ml-2">Working</div>
                                </div>
                            </div>
                        <div class="card-body"><h5 class="card-title">Employee Table</h5>
                            <table class="mb-0 table table-bordered data-table" id="example" style="display:table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Proof</th>
                                        <th>Address</th>
                                        <th>Joining</th>
                                        {{-- <th>Leave</th> --}}
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                  </thead>
                                 <tbody>
                                    @php
                                    $i=1;
                                    @endphp
                                    @foreach($model as $key => $value)
                                    @if(!empty($value->leave_date))
                                    <tr style="background-color: orange">
                                    @else
                                    <tr>
                                    @endif    
                                        <th scope="row">{{ $i++ }}</th>
                                        <td>{{ ucfirst($value->name) }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->mobile }}</td>
                                        <td><img src="../proof/{{ $value->proof }}" height="70" width="70"></td>
                                        <td>{{ ucfirst($value->address) }}</td>
                                        <td>{{ date("Y-m-d", strtotime($value->join_date)) }}</td>
                                        {{-- <td>{{(empty($value->leave_date) ? '' :date("Y-m-d", strtotime($value->leave_date)) )}}</td> --}}
                                        {{-- <td> {{ ($value->status == '1') ? 'Active' : 'Deactive' }}</td> --}}
                                        <td> <a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-{{$value->id}}').submit();" class="btn btn-sm btn-{{ ($value->status == '1') ? 'danger' : 'success' }}">
                                           {{ ($value->status == '1') ? 'Deactive' : 'Active' }}

                                        </a>
                                          <form id="status-{{$value->id}}" method="post" action="{{ route('menu.employee.status',['id'=>$value->id ,'status'=>$value->status])}}" style="display: none;">
                                          @csrf
                                        </form></td>
                                        {{-- <td>{{ App\Models\City::find($value->city)->name }}</td> --}}
                                        <td><a href="{{ route('menu.employee.edit',$value->id) }}"  data-info="{{$value->id}}" class="edits" ><i class="pe-7s-note"> </i></a>
                                                                              
                                         <a href="" onclick="if(confirm('Do you want to delete this detail?'))event.preventDefault(); document.getElementById('delete-{{$value->id}}').submit();" class="delete"><i class="pe-7s-trash"> </i></a>
                                          <form id="delete-{{$value->id}}" method="post" action="{{ route('menu.employee.destroy', $value->id)}}" style="display: none;">
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