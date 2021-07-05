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
                    <div>Add Role
                    </div>
                </div>
             </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title"></h5>
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif 
        <form class="" method="post" action="{{ route('admin.role.save') }}" enctype="multipart/form-data">
               @csrf
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Role</label>
                <div class="col-sm-10">
                    <input name="name" id="name" placeholder="Enter Role " type="text" class="form-control">
                </div>
            </div>
           {{--   <div class="position-relative row form-group">
            <label for="status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                        <select name="status" id="exampleSelect" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                </div>
            </div> --}}
            <div class="position-relative row form-check">
                <div class="col-sm-10 offset-sm-2">
                    <button class="btn btn-secondary">Submit</button>
                </div>
            </div>
        </form>
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
                            <a href="javascript:void(0);" class="nav-link">
                                Logout
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    
    @endsection