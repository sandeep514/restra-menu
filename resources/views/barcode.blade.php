<!doctype html>
<html class="no-js" lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.png">
		<link rel="stylesheet" href="{{ asset('barcode/other/css/normalize.css') }}">
		<!-- Main Css -->
		<link rel="stylesheet" href="{{ asset('barcode/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('barcode/css/font-awesome/css/font-awesome.css') }}">
		<link rel="stylesheet" href="{{ asset('barcode/css/plugin.css') }}">
		<link rel="stylesheet" href="{{ asset('barcode/css/main.css') }}">
		<link rel="stylesheet" href="{{ asset('barcode/other/css/animate.min.css') }}">


		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('barcode/other/css/fontawesome-all.min.css') }}">
		<!-- Flaticon CSS -->
		<link rel="stylesheet" href="{{ asset('barcode/other/fonts/flaticon.css') }}">
		<!-- Custom Css -->
		<link rel="stylesheet" href="{{ asset('barcode/other/style.css')}}">
		<!-- Modernizr Js -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
		<script src="{{ asset('barcode/other/js/jquery-3.3.1.min.js')}}"></script>
		<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
		<script src="{{ asset('barcode/other/js/modernizr-3.6.0.min.js')}}"></script>

		<style type="text/css">


				.restra_name{
					font-size: 50px!important;
					margin:5px 0!important;
				}
					.restra_adress{
					font-size: 25px!important;
					margin:5px 0!important;
							}
				.price{
					margin: 0!important;
				}
				h2{
					margin:5px!important;
					padding: 10px!important;
					/*border-bottom: 1px dotted;*/
				}
				.describe{
					font-size:14px!important;
				}h2,h3,h4,h5,h6{
					text-align:left !important;
				}
				h3{
					margin-top:0;
				}
				.h3{
					text-align:center !important;
				}
				.text-center{
					text-align: center!important;
				}
				.bgcolor-info{
  background-color: #d9edf7;
}
				.text-warning {
		color: #ffc107!important;
		}
		.seting-size img
		{
		height: 65%!important;
		}
		.font-setting{
		font-size: 12px; background-color:green;color:white; padding:3px;
		}
		.sellerFont{
		font-size: 12px; background-color:red;color:white; padding:3px;margin-top: 2px;
		}
		.mt-0{
		margin-top: 0!important;
		}
				.menu-item3  .described{
					/*float: none!important;*/
					font-size: 14px!important;
				}

.p-10{
	padding: 10px;
}
.checked {
color: orange;
line-height: 2.8;
}
.input-group {
    position: relative;
    display: flex;
    border-collapse: separate;}
.veg-cls{top: -4px;
    position: relative;}
.menu-block { margin-bottom: 30px; box-shadow: -19px 14px 35px -13px rgba(0,0,0,0.13);
-webkit-box-shadow: -19px 14px 35px -13px rgba(0,0,0,0.13);
-moz-box-shadow: -19px 14px 35px -13px rgba(0,0,0,0.13); padding:10px; border:#f1f1f1 solid 1px;}
.menu-title { border-bottom: 1px solid #e0e6e3; margin-bottom: 36px; padding-bottom: 10px; font-family: raleway, sans-serif; font-weight: 800;}
.menu-content { border-bottom: 1px solid #e0e6e3; margin-bottom: 30px; }
.dish-img { }
/*.img-circle {
    border-radius: 50%;
}*/
/*.dish-content {  margin-bottom: 40px; }*/
.dish-meta { font-size: 13px; display: block; line-height: 1.8; width: fit-content;}
.dish-title { margin-bottom: 6px; font-size: 23px; position: relative; font-family: josefin sans, sans-serif; width: }
.dish-price { position: absolute; right: 16px; top: 0px; font-size: 26px; color: #e03c23; font-weight: 500; font-family: 'Zilla Slab', serif; }
.well-block .dish-meta { width: 100%; }
.page-title{    padding: 5px;font-family: raleway, sans-serif; font-weight: 800;}
.well-block .dish-price { font-size: 26px; color: #e03c23; font-weight: 500; font-family: 'Zilla Slab', serif; position: inherit; }			
		</style>
	</head>
	<body>
		<div id="wrapper" class="wrapper">
			<!-- Header Area Start Here -->
			
			<section class="recipe-without-sidebar-wrap  padding-bottom-22">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<img  class="" src="{{ asset('images/'.$model->logo) }}" alt="">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="page-header wow fadeInDown mt-0">
								<h3 class="h3">{{$model->name}}
								{{-- <small>
								{{ucfirst($model->location)}}</small> --}}
								</h3>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8"><form style="display: inline-flex;" id="front_food_filter">
							@csrf
								{{ session()->put('rest_id', $model->id) }}
								<input type="hidden" value="{{ session()->get('rest_id') }}" name="id" id="comn_id">
						<div class="form-check form-check-inline p-10">
							  <input class="form-check-input " type="checkbox" id="checkboxed1" name="food_type_filter[]" value="1">
							  <label class="form-check-label" for ="checkboxed1">Veg</label>
							</div>
							<div class="form-check form-check-inline p-10">
							  <input class="form-check-input " type="checkbox" id="checkboxed2" name="food_type_filter[]" value="2">
							  <label class="form-check-label" for ="checkboxed2">Non Veg</label>
							</div>
						
					</div>
				</div>

					<div class="adv-search-wrap" id="MyDiv">
							<div class="input-group">
								{{-- {{ session()->put('rest_id', $model->id) }}
								<input type="hidden" value="{{ session()->get('rest_id') }}" name="id" id="comn_id"> --}}
								<input type="text" class="form-control" name="content" id="content_id" placeholder="Category Search . . ." />
								<div class="btn-group ">
									<div class="input-group-btn input-group-append adv-search-fill-btn">
										<button type="button" id="adv-serch" class="btn-adv-serch">
										<i class="icon-plus flaticon-add-plus-button"></i>
										<i class="icon-minus fas fa-minus"></i>
										Advanced Search
										</button>
									</div>
									

										

										{{-- <div class="input-group-btn">
											<input type="hidden" value="asc" name="filterprice" id="filterprice">
											<button type="button" id="filter_submit" class="btn-search"><i class="fas fa-sort-amount-up"></i></button>
										</div>
									
										<div class="input-group-btn">
											<input type="hidden" value="desc" name="filterprice" id="filterprice_desc">
											<button type="button" id="filter_submit_desc" class="btn-search"><i class="fas fa-sort-amount-down"></i></button>
										</div> --}}
									{{-- </form> --}}
								</div>
					             <div class="input-group-append">
								    <select class="custom-select" id="filter_submit" name="sort_filter">
								    <option disabled="">Sort...</option>
								    <option value="asc">Low to High</option>
								    <option value="desc">High To Low</option>
								  </select>
								</div>
							</div>
						{{-- </form> --}}
						<div class="advance-search-form">
							
								{{-- @csrf --}}
								{{-- {{ session()->put('rest_id', $model->id) }}
								<input type="hidden" value="{{ session()->get('rest_id') }}" name="id"> --}}
								<input type="hidden" value="" name="advancefilter" id="ads">
								<div class="row">
									<div class="col-lg-6">
										<h3 class="item-title">BY CATEGORIES</h3>
										<ul class="search-items">
											@foreach($categoried as $split)
											@if(!empty($split['subcat_withmenu']))
											<li>
												<div class="checkbox checkbox-primary">
													<input id="checkboxsubcat{{ $split['id'] }}" type="checkbox" value="{{ ucfirst($split['id']) }}" name="subactegory_filter[]">
													<label for="checkboxsubcat{{ $split['id'] }}">{{ ucfirst($split['dish_category']) }}</label>
												</div>
											</li>
											@else
											@endif
											@endforeach
										</ul>
									</div>
									<div class="col-lg-6">
										<h3 class="item-title">BY Type</h3>
										<ul class="search-items">
											<li>
												<div class="checkbox checkbox-primary">
													<input id="checkboxtypes{{ $model->id }}" type="checkbox" name="food_type[]" value="1">
													<label for="checkboxtypes{{ $model->id }}">Veg</label>
												</div>
											</li>
											<li>
												<div class="checkbox checkbox-primary">
													<input id="checkboxs{{ $model->id }}" type="checkbox" name="food_type[]" value="2">
													<label for="checkboxs{{ $model->id }}">Non Veg</label>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<h3 class="item-title">By Best Seller</h3>
										<ul class="search-items">
											<li>
												<div class="checkbox checkbox-primary">
													<input id="checkboxsel{{ $model->id }}" type="checkbox" value="1" name="best_seller">
													<label for="checkboxsel{{ $model->id }}">Best seller</label>
												</div>
											</li>
										</ul>
									</div>
									<div class="col-lg-6">
										<h3 class="item-title">BY Today chef</h3>
										<ul class="search-items">
											<li>
												<div class="checkbox checkbox-primary">
													<input id="checkboxt{{ $model->id }}" type="checkbox" value="1" name="chef">
													<label for="checkboxt{{ $model->id }}">Today chef</label>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="input-group-btn">
									<button type="submit" id="all_filter" class="btn btn-info">Search</button>
								</div>
						</div>
					</form>
					</div>

					
					</div>
					
				
						<div></div>
					</div>
				</section>
				{{-- <div class="content"> --}}
       
        <div class="content"  id="reload_div" >
        @include('layouts.filter')
       </div>
        
        {{-- <div id="search" class="search-wrap">
				<button type="button" class="close">×</button>
				<form class="search-form">
					<input type="search" value="" placeholder="Type here........" />
					<button type="submit" class="search-btn"><i class="flaticon-search"></i></button>
				</form>
			</div> --}}
{{-- </div> --}}
				<!-- Recipe Without Sidebar Area End Here -->
				<!-- Footer Area Start Here -->
				<footer class="menu-bg-dark">
					<div class="container">
						
						<div class="copyright">
							<p><i class="fa fa-copyright"></i> 2021.All rights reserved. <i class="fa fa-heart heart-fill"></i></p>
						</div>
					</div>
				</footer>
				
			</div>
			<!-- Search Box Start Here -->
			
			<!-- Search Box End Here -->
			<!-- Modal Start-->
			
			<script src="{{ asset('barcode/other/js/popper.min.js')}}"></script>
			<!-- Bootstrap Js -->
			<script src="{{ asset('barcode/other/js/bootstrap.min.js')}}"></script>
			<!-- Plugins Js -->
			<script src="{{ asset('barcode/other/js/plugins.js')}}"></script>
			<!-- Smoothscroll Js -->
			<script src="{{ asset('barcode/other/js/smoothscroll.min.js')}}"></script>
			<!-- Custom Js -->
			<script src="{{ asset('barcode/other/js/main.js')}}"></script>
			<script type="text/javascript">
			$(document).ready(function() {


				$('[data-fancybox]').fancybox({
		        toolbar: false,
		        smallBtn: false,
		        iframe: {
		            preload: false
		        }
		    })
		});

			    $('input[name="content"]').on('keyup', function(e) {
			        $.ajax({
			            type: 'post',
			            url: "{{ route('menus.list.filter') }}",
			            data:$('#front_food_filter').serialize(),
			            dataType:"json",
			            success: function(res) { 
			            	 var result=res;
			            	$('#reload_div').html(result.html);
			                setTimeout(function() {
			                    $('#success_message').fadeOut("slow");
			                }, 2000);
			            }
			        });
			        e.preventDefault();
			    });
 


			     $('input[name="food_type_filter[]"]').on('change', function(e) {
			        // alert(detail);
			        $.ajax({
			            type: 'post',
			            url: "{{ route('menus.list.filter') }}",
			             data:$('#front_food_filter').serialize(),
			            dataType:"json",
			            success: function(res) {

			                 var result=res;
			                $('#reload_div').html(result.html);
			                setTimeout(function() {
			                    $('#success_message').fadeOut("slow");
			                }, 2000);
			            }
			        });
			        e.preventDefault();
			    });

			    $('select[name="sort_filter"]').on('click', function(e) {
			        $.ajax({
			            type: 'post',
			            url: "{{ route('menus.list.filter') }}",
			             data:$('#front_food_filter').serialize(),
			            dataType:"json",
			            success: function(res) {
			                
			                var result=res;
			                // document.getElementById("filter-data").reset();
			                $('#reload_div').html(result.html);
			                setTimeout(function() {
			                    $('#success_message').fadeOut("slow");
			                }, 2000);
			            }
			        });
			        e.preventDefault();
			    });

			    $('#all_filter').on('click', function(e) {
			    	if($('input[type="checkbox"]:checked').length > 0)
			    	{
			    		$("#ads").val('1');
			    	}
			    	else{
			    		$("#ads").val('0');
			    	}

			        $.ajax({
			            type: 'post',
			            url: "{{ route('menus.list.filter') }}",
			            data:$('#front_food_filter').serialize(),
			            //dataType:"json",
			            success: function(res) {
			                // console.log(res);
			                // document.getElementById("filter-data").reset();
			                 var result=res;
			                $('#reload_div').html(result.html);
			                setTimeout(function() {
			                    $('#success_message').fadeOut("slow");
			                }, 2000);
			            }
			        });
			        e.preventDefault();
			    });
			    
						</script>
		</body>
	</html>
