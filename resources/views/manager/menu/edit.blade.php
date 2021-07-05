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
                    <div>Edit Menu                             
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
         <form class="" method="post" action="{{ route('menu.update',$detail->id) }}"  enctype="multipart/form-data">
            @method('PUT')
               @csrf
               <input type="hidden"  id="sub_id" name="sub_id" value="{{ $detail->subcategory_id }}">
           <div class="position-relative row form-group">
            <label for="dish_category" class="col-sm-2 col-form-label">Dish Category</label>
                <div class="col-sm-10">
                    <select  id="dish_category" class="form-control" name="dish_category">
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
             <label for="dish_subcategory" class="col-sm-2 col-form-label">Dish Subcategory</label>
                <div class="col-sm-10">

                    <select  id="dish_subcategory" class="form-control" name="dish_subcategory">

                    </select>
                </div>
            </div>
          {{--   <div class="position-relative row form-group">
            <label for="status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ $detail->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $detail->status == 0 ? 'selected' : '' }}>Deactive</option>
                        </select>
                </div>
            </div> --}}
            <div class="position-relative row form-group">
                <label for="menu_name" class="col-sm-2 col-form-label">Menu Name</label>
                <div class="col-sm-10">
                    <input type="text" id="menu_name" value="{{ $detail->menu_name }}" name="menu_name" placeholder="Enter  Name" class="form-control name_list" />
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
                <label for="price" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input type="text" name="price" value="{{ $detail->price }}" id="price"  placeholder="Enter price" class="form-control name_list" onkeypress ="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))"/>
                </div>
            </div> 
            <div class="position-relative row form-group">
             <label for="rating" class="col-sm-2 col-form-label">Rating</label>
                <div class="col-sm-10">

                    <select name="rating" id="rating" class="form-control name_list">
                                        <option value="">Select Rating</option>
                                        <option value="1" {{ $detail->rating == 1 ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ $detail->rating == 2? 'selected' : '' }}>2</option>
                                        <option value="3" {{ $detail->rating == 3 ? 'selected' : '' }}>3</option>
                                        <option value="4" {{ $detail->rating == 4 ? 'selected' : '' }}>4</option>
                                        <option value="5" {{ $detail->rating == 5 ? 'selected' : '' }}>5</option>
                     </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="dish_subcategory" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" maxlength="250" cols="45" class="form-control" >{{ $detail->description }} </textarea>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="dish_subcategory" class="col-sm-2 col-form-label">Discount</label>
                <div class="col-sm-10">
                    <input type="text" name="discount"  class="form-control name_list" value="{{ $detail->discount }}" onkeypress ="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))"/>
                </div>
            </div>
             <div class="position-relative row form-group">
                <label  class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-10">
                    <div class="position-relative form-check">
                        <label class="form-check-label">
                            <input name="foodstatus" type="radio" class="form-check-input" value="1" {{ $detail->foodstatus == 1 ? 'checked' : '' }}>
                            Vegetarian
                        </label>
                    </div>
                    <div class="position-relative form-check">
                        <label class="form-check-label">
                            <input name="foodstatus" type="radio" class="form-check-input" value="2" {{ $detail->foodstatus == 2 ? 'checked' : '' }}>
                            Non Vegetarian
                        </label>
                    </div>
                    
                    </div>
            </div>


           
               {{--  <div class="table-responsive-sm">
                    <table class="table table-striped" id="new">
                        <thead>
                            <tr>                                
                                 <th>Name</th>
                                 <th>Price</th>
                                 <th>Description</th>
                                 <th>Action
                            </tr>
                        </thead>
                          <tbody id="tdata">
                            <tr>
                                <td><input type="text" name="menu_name[]" placeholder="Enter  Name" class="form-control name_list" /></td>
                                <td><input type="text" name="price[]" placeholder="Enter price" class="form-control name_list" /></td>
                                <td><textarea name="description[]" maxlength="250"></textarea></td>
                                 <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td> 
                            </tr>
                          </tbody>
                         </table>
                         </div> 
            --}}
             
            <div class="position-relative row form-check">
               <div class="col-sm-10 offset-sm-2">
                    <button class="btn btn-primary">Submit</button>
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
        $(document).ready(function () {

            $('#dish_category').on('change', function () {
                subcategory();
            });

            function subcategory(){
                var idcat = $('#dish_category').val();
                var subcat= $('#sub_id').val();
                // alert(idcat);
                $("#dish_subcategory").html('');
                $.ajax({
                    url: "{{url('/fetch-subcategory')}}",
                    type: "POST",
                    data: {
                        category_id: idcat,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#dish_subcategory').html('<option value="">Select subcategory</option>');
                        $.each(result.Subcategories, function (key, value) {
                            if(value.id==subcat){
                            $("#dish_subcategory").append('<option value="' + value
                                .id + '" selected>' + value.dish_subcategory +'</option>');
                        }
                        else{
                            $("#dish_subcategory").append('<option value="' + value
                                .id + '">' + value.dish_subcategory +'</option>');
                        }
                        });
                       
                    }
                }); 
            }

        subcategory(); 

        });

    </script>
    @endsection