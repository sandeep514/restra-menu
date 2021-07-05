<?php
use Carbon\Carbon; 
?>
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
                    <div>Add Restuarant
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
        <form class="" method="post" action="{{ route('admin.resturant.save') }}" enctype="multipart/form-data">
               @csrf
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Restaurant Name</label>
                <div class="col-sm-10">
                    <input name="name" id="name" placeholder="Enter  name" type="text" class="form-control">
                </div>
            </div>
             <div class="position-relative row form-group">
                <label for="location" class="col-sm-2 col-form-label">Location</label>
                <div class="col-sm-10">
                    <input name="location" id="location" placeholder="Enter  Location" type="text" class="form-control">
                </div>
            </div>
             <div class="position-relative row form-group">
                <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                <div class="col-sm-10">
                    <input name="contact" id="contact" placeholder="Enter  Contact" type="text" class="form-control" minlength="10" maxlength="10" onkeypress="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))" required=""> 
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="country-dd" class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-10">
                    <select  id="country-dd" class="form-control" name="country">
                            <option value="">Select Country</option>
                            @foreach ($countries as $data)
                            <option value="{{$data->id}}" {{ $data->id ==' 101'? 'selected' : ''}}>
                                {{$data->name}}
                            </option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="state-dd" class="col-sm-2 col-form-label">State</label>
                <div class="col-sm-10">
                     <select id="state-dd" class="form-control" name="state">
                        </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="city-dd" class="col-sm-2 col-form-label">City</label>
                <div class="col-sm-10">
                      <select id="city-dd" class="form-control" name="city">
                        </select>
                </div>
            </div>
             <div class="position-relative row form-group">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" id="description" class="form-control"></textarea> 
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="logo" class="col-sm-2 col-form-label">Logo</label>
                <div class="col-sm-10">
                    <input name="logo" placeholder="select image" type="file" class="form-control" id="logo" required>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input name="email" id="email" placeholder="Enter  Email" type="email" class="form-control" >
                </div>
            </div>
             <div class="position-relative row form-group">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input name="password" id="password" placeholder="Enter  Password" type="password" class="form-control" >
                    <input type="hidden" name="role_id" value="2">
                </div>
            </div>
              <div class="position-relative row form-group">
                <label for="inlineRadio1" class="col-sm-2 col-form-label">Membership</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  id="inlineRadio1" value="1"  name="member_type" checked>
                        <label class="form-check-label" for="inlineRadio1">Monthly</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  id="inlineRadio2" value="2" name="member_type">
                        <label class="form-check-label" for="inlineRadio2">Yearly</label>
                    </div>
                </div>
            </div> 
          <div class="position-relative row form-group" id="month_member">
            <label for="monthly" class="col-sm-2 col-form-label">Monthly</label>
            <div class="col-sm-10">
                        <select name="membership_interval" id="monthly" class="form-control" >
                            <option value="1" selected>1 Month</option>
                            <option value="2">2 Months</option>
                            <option value="3">3 Months</option>
                            <option value="4">4 Months</option>
                            <option value="5">5 Months</option>
                            <option value="6">6 Months</option>
                            <option value="7">7 Months</option>
                            <option value="8">8 Months</option>
                            <option value="9">9 Months</option>
                            <option value="10">10 Months</option>
                            <option value="11">11 Months</option>
                            <option value="12">12 Months</option>
                        </select>
                </div>
            </div>
            <input type="hidden" value="" name="expiry_date" class="month_expiry">
            <div class="position-relative row form-group" id="month_interval">
            <label for="monthly" class="col-sm-2 col-form-label">Interval</label>
            <div class="col-sm-10 month_int">
            </div>
            </div>

            <div class="position-relative row form-group" id="year_member" style="display: none;">
            <label for="yearly" class="col-sm-2 col-form-label">Yearly</label>
            <div class="col-sm-10">
                        <select name="membership_interval" id="yearly" class="form-control">
                            <option value="1">1 Year</option>
                            <option value="2">2 Years</option>
                            <option value="3">3 Years</option>
                            <option value="4">4 Years</option>
                            <option value="5">5 Years</option>
                        </select>
            </div>
            </div>
           
            <div class="position-relative row form-group" id="year_interval" style="display: none;">
            <label for="monthly" class="col-sm-2 col-form-label">Interval</label>
            <div class="col-sm-10 year_int">
            </div>
            </div>
            
             <input type="hidden" value="" name="expiry_date" class="expiry_date">
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
                var idState = this.value;
                $("#city-dd").html('');
                $.ajax({
                    url: "{{url('/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#city-dd').html('<option value="">Select City</option>');
                        $.each(res.cities, function (key, value) {
                            $("#city-dd").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
            $('input[name=member_type').click(function(){
                if($(this).val() == '1'){
                    $('#month_member').show();
                    $('#year_member').hide();
                    $('#month_interval').show();
                    $('#year_interval').hide();
                }else{
                    $('#year_member').show();
                    $('#month_member').hide();
                     $('#year_interval').show();
                    $('#month_interval').hide();
                }
            });
       
      $('#yearly').change(function(){         
       var year_id=$(this).val();
        var currentDate = moment().format('YYYY-MM-DD');
        var futureYear = moment().add(year_id, 'Y').format('YYYY-MM-DD');
        $('.year_int').html("<span>" + currentDate + " To "+ futureYear +"</span>");
        $('.expiry_date').val(futureYear);

 });
        $('#monthly').change(function(){
         
        var month_id= $(this).val();
        var currentDate = moment().format('YYYY-MM-DD');
        var futureMonth = moment().add(month_id, 'M').format('YYYY-MM-DD');
        $('.month_int').html("<span>" + currentDate + " To "+ futureMonth +"</span>");
        $('.expiry_date').val(futureMonth);
 });

         });
    </script>
    @endsection