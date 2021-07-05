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
                    <div>Edit Employee                             
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
        {{-- <form class="" method="post" action={{ route('admin.resturant.save') }} > --}}
            <form class="" method="post" action="{{ route('menu.employee.update',$detail->id) }}" enctype="multipart/form-data">
             @method('PUT')
               @csrf
      
               {{-- <input type="hidden" name="restra_id" value="1"> --}}
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input name="name" id="name" placeholder="Enter name" type="text" class="form-control" value="{{ $detail->name }}">
                </div>
            </div>
             <div class="position-relative row form-group">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input name="email" id="email"  type="text" class="form-control" value="{{ $detail->email }}">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="mobile" class="col-sm-2 col-form-label">Contact</label>
                <div class="col-sm-10">
                    <input name="mobile"  value="{{ $detail->mobile }}" placeholder="Enter Contact number" type="text" minlength="10" maxlength="10" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" class="form-control" required>
                </div>
            </div>
              <div class="position-relative row form-group">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input name="address" placeholder="Enter Address" value="{{ $detail->address }}" type="text" class="form-control" required>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="proof" class="col-sm-2 col-form-label">Proof</label>
                <div class="col-sm-10">
                    @if($detail->proof)
                        <img id="original" src="{{ url('/proof/'.$detail->proof) }}" height="70" width="70">
                    @endif
                    <input name="proof" placeholder="select image" type="file" class="form-control"  value="{{ $detail->proof }}" >
                </div>
            </div>
           <div class="position-relative row form-group">
            <label for="police_verify" class="col-sm-2 col-form-label">Verification</label>
            <div class="col-sm-10">
                        <select name="police_verify" id="exampleSelect" class="form-control">
                            <option value="0" {{ $detail->status == 0 ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $detail->status == 1 ? 'selected' : '' }}>Done</option>
                        </select>
            </div>
            </div>
            <div class="position-relative row form-group">
                <label for="join_date" class="col-sm-2 col-form-label">Join Date</label>
                <div class="col-sm-10">
                    <input name="join_date" placeholder="Join date" type="date" class="form-control " value={{ $detail->join_date}}>
                </div>
            </div> 
             <div class="position-relative row form-group">
                <label for="leave_date" class="col-sm-2 col-form-label">Leave Date</label>
                <div class="col-sm-10">
                    <input name="leave_date" placeholder="Leave date" type="date" class="form-control" value={{ $detail->leave_date}} >
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="reason" class="col-sm-2 col-form-label">Reason</label>
                <div class="col-sm-10">
                    <input name="reason" placeholder="Enter reason to leave" type="text" class="form-control" value={{ $detail->reason }} >
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="salary" class="col-sm-2 col-form-label">Salary</label>
                <div class="col-sm-10">
                    <input name="salary" placeholder="Enter Salary" type="number" class="form-control" value={{ $detail->salary }} required>
                </div>
            </div>
           {{-- <div class="position-relative row form-group">
            <label for="checkbox2" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                        <select name="status" id="exampleSelect" class="form-control">
                            <option value="1" {{ $detail->status == 1 ? 'selected' : '' }} >Active</option>
                            <option value="0" {{ $detail->status == 0 ? 'selected' : '' }} >Deactive</option>
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
    <script>
    </script>
    @endsection