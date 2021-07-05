<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title></title>
		<!-- <link rel="shortcut icon" href="img/favicon.ico"> -->
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="{{ asset('barcode/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('barcode/css/font-awesome/css/font-awesome.css') }}">
		<link rel="stylesheet" href="{{ asset('barcode/css/plugin.css') }}">
		<link rel="stylesheet" href="{{ asset('barcode/css/main.css') }}">
		<link rel="stylesheet" href="{{ asset('/css/main.css') }}">

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
			.text-warning {
    color: #ffc107!important;
}

.font-setting{
	font-size: 12px; background-color:green;color:white; padding:5px;
}

.mt-0{
	margin-top: 0!important;
}
			.menu-item3  .described{
				/*float: none!important;*/
				font-size: 14px!important;
			}
		</style>
	</head>
	<body>
		<div class="body">
			<div class="main-wrapper">
				<section class="menu space60">
					<div class="container">
						<div class="row">
							<div class="col-md-12 text-center">
									 <img  class="rounded-circle" src="{{ asset('images/'.$model->logo) }}" alt="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="page-header wow fadeInDown mt-0">
									<h3 class="h3">{{$model->name}}
										{{-- <small>
										{{ucfirst($model->location)}}</small> --}}
									</h3>
								</div>
							</div>
						</div>
						
						<div class="food-menu wow fadeInUp row">
							<div class="container menu-items3 doot">
								@foreach($categories as $category)
								@if(!empty($category['subcat_withmenu']))
								<h2 class="text-center p-5 bg-info">{{ ucfirst($category['dish_category']) }}</h2>
								@else
								@endif
								<div class="dotted-bg"></div>
								@foreach($category['subcat_withmenu'] as $subcat)
								<div class="row">
								<div class="menu-item3 col-sm-12 col-xs-12 ">

								<div class="row "> <div class="col-md-12"><h3>{{ $subcat['dish_subcategory'] }}</h3></div></div>
								<div class="row ">										
								@foreach($subcat['allmenu'] as $menu)	
								<div style="width:10%; margin-left: 3px;">
								@if($menu['foodstatus'] == '1')
										<img src="../category/veg.png" style="height:20px;width:20px" alt="" />									
							@else
										<img src="../category/nonveg.png" style="height:20px;width:20px" alt="" />									
							@endif
						</div>
								<div style="width:20% ; margin-left: 30px;">
										<img src="../category/{{ $menu['image'] }}" class="rounded-circle"  height="70" width="70" alt="" />												
								</div>

								  <div class="col-md-10 doot">																			
									
										<p class="text-left" style="width:100%">{{ ucfirst($menu['menu_name']) }}
										<span class="rating">
										@for( $j = 1 ; $j <= $menu['rating']; $j++ )
                                                    <i class="fa fa-star text-warning" style="font-size:20px;"></i>
                                          @endfor
                                      </span>
                                      <span class="text-left {{ ($menu['chef_special'] == '1') ? 'font-setting' : '' }}">{{ ($menu['chef_special'] == '1') ? 'Chef Special' : '' }}</span>
    										@if($menu['discount']==0)
											<span class="price">₹{{ $menu['price'] }}</span>
											@else
											<span class="discount">₹{{ $menu['discount'] }}</span>
											<span class="price"><strike>₹{{ $menu['price'] }}</strike></span>
											@endif
											@if($menu['best_seller']=='1')
											<img src="../images/seller.jpg" height="30" width="30" alt="" style="float: right"/>	
											@endif                                  
									</p><br>
										<p class="described text-left">{{ ucfirst($menu['description']) }}</p>

										
									</div><br>
										@endforeach
									</div>	
									</div></div>
								@endforeach
								@endforeach
							</div>
						</div>
					</div>
				</section>
				<section class="footer">
					<div class="footer-copyrights">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<p><i class="fa fa-copyright"></i> 2021.All rights reserved. <i class="fa fa-heart primary-color"></i></p>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<script src="{{ asset('barcode/js/jquery-1.11.2.min.js') }}"></script>
		<script src="{{ asset('barcode/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('barcode/js/jquery.flexslider-min.js') }}"></script>
		<script src="{{ asset('barcode/js/owl.carousel.min.js') }}"></script>
		<script src="{{ asset('barcode/js/jquery.magnific-popup.min.js') }}"></script>
		<script src="{{ asset('barcode/js/isotope.pkgd.min.js') }}"></script>
		<script src="{{ asset('barcode/js/wow.min.js') }}"></script>
		<script src="{{ asset('barcode/js/main.js') }}"></script>
	</body>
</html>