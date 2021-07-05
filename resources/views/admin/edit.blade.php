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
                    <div>Edit Restuarant
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
        <form class="" method="post"  enctype="multipart/form-data" action={{ route('admin.resturant.update',$detail->id) }} >
             @method('PUT')
               @csrf
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Restaurant Name</label>
                <div class="col-sm-10">
                    <input name="name" id="name" placeholder="Enter  name" type="text" class="form-control" value="{{ $detail->name }}" maxlength="100">
                </div>
            </div>
             <div class="position-relative row form-group">
                <label for="location" class="col-sm-2 col-form-label">Location</label>
                <div class="col-sm-10">
                    <input name="location" id="location" placeholder="Enter Location" type="text" class="form-control" value="{{ $detail->location }}">
                </div>
            </div>
             <div class="position-relative row form-group">
                <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                <div class="col-sm-10">
                    <input name="contact" id="contact" placeholder="Enter  Contact" type="text" class="form-control"  value='{{ $detail->contact }}' minlength="10" maxlength="10" onkeypress="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))" required=""> 
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="country-dd" class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-10">
                    <select  id="country-dd" class="form-control" name="country">
                            <option value="">Select Country</option>
                            @foreach ($countries as $data)
                            <option value="{{$data->id}}" {{ $detail->country == $data->id ? 'selected' : ''}}>
                                {{$data->name}}
                            </option>
                            @endforeach
                        </select>
                </div>
            </div>
            <input type="hidden" value="{{ $detail->state}}" id="states_id">
            <input type="hidden" value="{{ $detail->city}}" id="cities_id">
            <div class="position-relative row form-group">
                <label for="price" class="col-sm-2 col-form-label">State</label>
                <div class="col-sm-10">
                     <select id="state-dd" class="form-control" name="state">
                        </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="size" class="col-sm-2 col-form-label">City</label>
                <div class="col-sm-10">
                      <select id="city-dd" class="form-control" name="city">
                        </select>
                </div>
            </div> 
            <div class="position-relative row form-group">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" class="form-control">{{ $detail->description  }}</textarea> 
                </div>
            </div>
             <div class="position-relative row form-group">
                <label for="logo" class="col-sm-2 col-form-label">Logo</label>
                <div class="col-sm-10">
                    @if($detail->logo)
                        <img id="original" src="{{ url('/images/'.$detail->logo) }}" height="70" width="70">
                    @endif
                    <input name="logo" placeholder="select image" type="file" class="form-control"  >
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input name="email" id="email" placeholder="Enter  Email" type="email" class="form-control"  value="{{ $detail->email }}" readonly="">
                </div>
            </div> 
             <div class="position-relative row form-group">
                <label for="inlineRadio1" class="col-sm-2 col-form-label">Membership</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  id="inlineRadio1" value="1"  name="member_type" {{ $user_detail->member_type == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="inlineRadio1">Monthly</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  id="inlineRadio2" value="2" name="member_type" {{ $user_detail->member_type == 2 ? 'checked' : '' }}>
                        <label class="form-check-label" for="inlineRadio2">Yearly</label>
                    </div>
                </div>
            </div> 
          <div class="position-relative row form-group" id="month_member">
            <label for="monthly" class="col-sm-2 col-form-label">Monthly</label>
            <div class="col-sm-10">
                        <select name="membership_interval" id="monthly" class="form-control" >
                            <option value="1" {{ $user_detail->membership_interval == 1 ? 'selected' : '' }}>1 Month</option>
                            <option value="2" {{ $user_detail->membership_interval == 2 ? 'selected' : '' }}>2 Months</option>
                            <option value="3" {{ $user_detail->membership_interval == 3 ? 'selected' : '' }}>3 Months</option>
                            <option value="4" {{ $user_detail->membership_interval == 4 ? 'selected' : '' }}>4 Months</option>
                            <option value="5" {{ $user_detail->membership_interval == 5 ? 'selected' : '' }}>5 Months</option>
                            <option value="6" {{ $user_detail->membership_interval == 6 ? 'selected' : '' }}>6 Months</option>
                            <option value="7" {{ $user_detail->membership_interval == 7 ? 'selected' : '' }}>7 Months</option>
                            <option value="8" {{ $user_detail->membership_interval == 8 ? 'selected' : '' }}>8 Months</option>
                            <option value="9" {{ $user_detail->membership_interval == 9 ? 'selected' : '' }}>9 Months</option>
                            <option value="10" {{ $user_detail->membership_interval == 10 ? 'selected' : '' }}>10 Months</option>
                            <option value="11" {{ $user_detail->membership_interval == 11 ? 'selected' : '' }}>11 Months</option>
                            <option value="12" {{ $user_detail->membership_interval == 12 ? 'selected' : '' }}>12 Months</option>
                        </select>
                </div>
            </div>
            <input type="hidden" value="" name="expiry_date" class="month_expiry" >
            <div class="position-relative row form-group" id="month_interval" style="display:none">
            <label for="monthly" class="col-sm-2 col-form-label">Expiry Date</label>
            <div class="col-sm-10 month_int">
            </div>
            </div>

            <div class="position-relative row form-group" id="year_member" style="display: none;">
            <label for="yearly" class="col-sm-2 col-form-label">Yearly</label>
            <div class="col-sm-10">
                        <select name="membership_interval" id="yearly" class="form-control">
                            <option value="1" {{ $user_detail->membership_interval == 1 ? 'selected' : '' }}>1 Year</option>
                            <option value="2" {{ $user_detail->membership_interval == 2 ? 'selected' : '' }}>2 Years</option>
                            <option value="3" {{ $user_detail->membership_interval == 3 ? 'selected' : '' }}>3 Years</option>
                            <option value="4" {{ $user_detail->membership_interval == 4 ? 'selected' : '' }}>4 Years</option>
                            <option value="5" {{ $user_detail->membership_interval == 5 ? 'selected' : '' }}>5 Years</option>
                        </select>
            </div>
            </div>
           
            <div class="position-relative row form-group" id="year_interval" style="display: none;">
            <label for="monthly" class="col-sm-2 col-form-label">Expiry Date</label>
            <div class="col-sm-10 year_int">
            </div>
            </div>

            <div class="position-relative row form-group" id="all_interval" >
            <label for="monthly" class="col-sm-2 col-form-label">Expiry Date</label>
            <div class="col-sm-10 ">
                <span>{{ $detail->expiry_date }}</span>
            </div>
            </div>
            
             <input type="hidden" value="{{ $detail->expiry_date }}" name="expiry_date" class="expiry_date">
         
            {{--  <div class="position-relative row form-group">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input name="password" id="password" placeholder="Enter  Password" type="password" class="form-control" readonly="">
                </div>
            </div> --}}
            <div class="position-relative row form-check-inline">
                <div class="col-sm-4 offset-sm-1">
                    <a href="{{ route('password.reset') }}" class="btn btn-secondary">Password Reset</a>
                </div>
                <div class="col-sm-4 offset-sm-3">
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
        $(document).ready(function () {
            state();

            $('#country-dd').on('change', function () {
                state();
            });

            function state(){
                var idCountry = $('#country-dd').val();
                var idstate = $('#states_id').val();
                $("#state-dd").html('');
                $.ajax({
                    url: "{{url('/fetch-states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#state-dd').html('<option value="">Select State</option>');
                        $.each(result.states, function (key, value) {
                             if(value.id==idstate){
                            $("#state-dd").append('<option value="' + value
                                .id + '" selected>' + value.name +'</option>');
                            city();
                        }
                        else{
                            $("#state-dd").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        }
                        });
                        $('#city-dd').html('<option value="">Select City</option>');
                       
                    }
                });
            }
            
            $('#state-dd').on('change', function () {
                city();
            });
            function city(){  
            if(($('#state-dd').val())==($('#states_id').val()))              
                var idstate = $('#states_id').val();
           
            else{
                var idstate = $('#state-dd').val();
                
            }

                var idcity = $('#cities_id').val();
               
                $("#city-dd").html('');
                $.ajax({
                    url: "{{url('/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state_id: idstate,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        $('#city-dd').html('<option value="">Select City</option>');
                        $.each(res.cities, function (key, value) {
                             if(value.id==idcity){
                            $("#city-dd").append('<option value="' + value
                                .id + '" selected>' + value.name +'</option>');
                        }
                        else{
                            $("#city-dd").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        } 
                        });
                    }
                });


            }

var mem_type=$("input:radio[name=member_type]:checked").val();
if(mem_type=='1')
{
    $('#year_member').hide();
     $('#month_member').show();
    $('#month_interval').hide();
    $('#all_interval').show();
}
else{
   $('#month_member').hide();
   $('#year_member').show();
    $('#year_interval').hide();
     $('#all_interval').show();
}


              $('input[name=member_type]').click(function(){
                if($(this).val() == '1'){
                    $('#month_member').show();
                    $('#year_member').hide();
                    $('#month_interval').show();
                    $('#year_interval').hide();
                    $('#all_interval').hide();
                }else{
                    $('#year_member').show();
                    $('#month_member').hide();
                     $('#year_interval').show();
                    $('#month_interval').hide();
                      $('#all_interval').hide();
                }
            });
       
      $('#yearly').change(function(){         
       var year_id=$(this).val();
        var currentDate = moment().format('YYYY-MM-DD');
        var futureYear = moment().add(year_id, 'Y').format('YYYY-MM-DD');
        $('.year_int').html("<span>" + currentDate + " To "+ futureYear +"</span>");
        $('.expiry_date').val(futureYear);
        $('#all_interval').hide();


 });
        $('#monthly').change(function(){
         
        var month_id= $(this).val();
        var currentDate = moment().format('YYYY-MM-DD');
        var futureMonth = moment().add(month_id, 'M').format('YYYY-MM-DD');
        $('.month_int').html("<span>" + currentDate + " To "+ futureMonth +"</span>");
        $('.expiry_date').val(futureMonth);
        $('#all_interval').hide();

 });
});
    </script>
    @endsection