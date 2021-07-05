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
                    <div>Edit Table                             
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
            <form class="" method="post" action="{{ route('menu.table.update',$detail->id) }}" enctype="multipart/form-data">
             @method('PUT')
               @csrf
      
               {{-- <input type="hidden" name="restra_id" value="1"> --}}
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Table Number</label>
                <div class="col-sm-10">
                    <input name="table_number" id="name" minlength="1" maxlength="2" placeholder="Enter table number" type="text" class="form-control" value="{{ $detail->table_number }}">
                </div>
            </div>

             <div class="position-relative row form-group">
                <label for="capacity" class="col-sm-2 col-form-label">Capacity</label>
                <div class="col-sm-10">
                    <input name="capacity" id="capacity" minlength="1" maxlength="2" placeholder="Enter capacity" type="text" class="form-control" value="{{ $detail->capacity }}">
                </div>
            </div>
           
           <div class="position-relative row form-group">
            <label for="checkbox2" class="col-sm-2 col-form-label">Table Status</label>
            <div class="col-sm-10">
                        <select name="status" id="exampleSelect" class="form-control">
                            <option value="0" {{ $detail->booking_status == 0 ? 'Reserved' : '' }} >Reserved</option>
                            <option value="1" {{ $detail->booking_status == 1 ? 'Available' : '' }} >Available</option>
                            <option value="2" {{ $detail->booking_status == 2 ? 'Damage' : '' }} >Damage</option>
                        </select>
                </div>
            </div>
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