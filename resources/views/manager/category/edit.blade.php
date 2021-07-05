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
                    <div>Edit Category                             
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
            <form class="" method="post" action="{{ route('menu.category.update',$detail->id) }}" enctype="multipart/form-data">
             @method('PUT')
               @csrf
      
               {{-- <input type="hidden" name="restra_id" value="1"> --}}
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Category Name</label>
                <div class="col-sm-10">
                    <input name="dish_category" id="name" placeholder="Enter dish category" type="text" class="form-control" value="{{ $detail->dish_category }}">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    @if($detail->image)
                        <img id="original" src="{{ url('/category/'.$detail->image) }}" height="70" width="70">
                    @endif
                    <input name="image" placeholder="select image" type="file" class="form-control"  >
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="priority" class="col-sm-2 col-form-label">Priority</label>
                <div class="col-sm-10">
                    <select name="priority" id="priority" class="form-control">
                            <option >Select Priority</option>
                            <option value="1" {{ $detail->status == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $detail->status == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $detail->status == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $detail->status == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $detail->status == 5 ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $detail->status == 6 ? 'selected' : '' }}>6</option>
                            <option value="7" {{ $detail->status == 7 ? 'selected' : '' }}>7</option>
                            <option value="8" {{ $detail->status == 8 ? 'selected' : '' }}>8</option>
                            <option value="9" {{ $detail->status == 9 ? 'selected' : '' }}>9</option>
                            <option value="10" {{ $detail->status == 10 ? 'selected' : '' }}>10</option>
                        </select>
                </div>
            </div>
          {{--  <div class="position-relative row form-group">
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