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
                    <div>Edit Subcategory                             
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
        <form class="" method="post" action="{{ route('menu.subcategory.update',$detail->id) }}" enctype="multipart/form-data">
            @method('PUT')
               @csrf
           <div class="position-relative row form-group">
            <label for="cat_id" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
            <select name="category_id" id="cat_id" class="form-control">
                <option value="">Select Dish Category</option>
                @foreach ($categories as $data)
                <option value="{{$data->id}}" {{ $detail->category_id == $data->id ? 'selected' : '' }}>
                    {{$data->dish_category}}
                </option>
                @endforeach
            </select>
            </div>
            </div>
            <div class="position-relative row form-group">
                <label for="subcategory" class="col-sm-2 col-form-label">Sub Category</label>
                <div class="col-sm-10">
                    <input name="dish_subcategory" id="subcategory" placeholder="Subcategory" value="{{ $detail->dish_subcategory }}" type="text" class="form-control">
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
           {{--  <div class="position-relative row form-group">
                <label  class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-10">
                    <div class="position-relative form-group">
                        <div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="dish_type[]" id="exampleCustomInline" class="custom-control-input" value="1" {{ $detail->status == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="exampleCustomInline">Vegetarian</label>
                            </div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="dish_type[]" id="exampleCustomInline2" class="custom-control-input" value="0" {{ $detail->status == 0 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="exampleCustomInline2">Non Vegetarian</label>
                            </div>
                        </div>
                        </div>
                    </div>
            </div> --}}
           {{-- <div class="position-relative row form-group">
            <label for="status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ $detail->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $detail->status == 0 ? 'selected' : '' }}>Deactive</option>
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