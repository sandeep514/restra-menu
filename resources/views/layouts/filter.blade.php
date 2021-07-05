<div class="container">
        @foreach($categories as $k=>$sub)
        <div class="row cat{{ $k }}">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center
                ">
                <div class="page-section bgcolor-info">
                    <h1 class="page-title">{{ ucfirst($k) }}</h1>
                </div>
            </div>
        </div>
        <div class="row cat{{ $k }}">
            <!-- starter -->
            <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12 ">

                @foreach($sub as $subcat=>$scategory)
                <div class="menu-block ">
                   <h2 class="menu-title">{{ ucfirst($subcat) }}</h2> 
                    <div class="menu-content">
                        @foreach($scategory as $menukey=>$menuvalue)
                        <div class="row ">
                        	<div class="col-lg-1 col-md-2 col-sm-3 col-xs-3" style="float: right;">
                        	@if($menuvalue->best_seller=='1')
							<img src="{{ asset('/images/seller.jpg') }}" alt=""/>	
							@endif                                  
						</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                <div class="dish-img"><a data-fancybox="gallery" href="../category/{{ $menuvalue->image }}"  data-caption="{{ ucfirst($menuvalue->description) }}<br> &nbsp;{{ ucfirst($menuvalue->menu_name) }}@if($menuvalue->foodstatus == '1'))

                            <img src='{{ asset('/category/veg.png') }}' style='height:20px;width:20px' alt='' />
                            @else
                            <img src='{{ asset('/category/nonveg.png') }}' style='height:20px;width:20px' alt='' />
                            @endif<br> @for( $j = 1 ; $j <= $menuvalue->rating; $j++ )
                            <i class='fa fa-star text-warning' style='font-size:20px;'></i>
                            @endfor
                        " >                       
                        <img src="{{ asset('category/'.$menuvalue->image) }}" class="img-circle" alt="" /></a>
                          
                         
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-7">
                            <div class="dish-content">
                                <p class="dish-title">{{ ucfirst($menuvalue->menu_name) }} 
                                  @if($menuvalue->foodstatus == '1')
                                      <img src="{{ asset('/category/veg.png') }}"  width="15px;" class="veg-cls"/>
				                        @else
				                                  <img src="{{ asset('/category/nonveg.png') }}" width="15px;" class="veg-cls"/>                       
				                        @endif  
				                       </p>

                                <span class="dish-meta">{{ ucfirst($menuvalue->description)}}</span>
                                <span class="checked">
                                 @for( $j = 1 ; $j <= $menuvalue->rating; $j++ )
                                <i class="fa fa-star text-warning" style="font-size:15px;"></i>
                                @endfor
                                </span>
                                

                              <span class="text-left {{ ($menuvalue->chef_special == '1') ? 'font-setting' : '' }}">{{ ($menuvalue->chef_special == '1') ? 'Chef Special' : '' }}</span>
                              </div>
                            
                            
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                              @if($menuvalue->discount==0)
                              <div class="dish-price">
                                    <p>₹{{ $menuvalue->price }}</p>
                                </div>
                              @else
                              <div class="dish-price">
                                <span class="discount">₹{{ $menuvalue->discount }}</span>
                                    <p><strike>₹{{ $menuvalue->price }}</strike></p>
                                </div>
                                @endif
                          </div>  

                    </div>               
                        @endforeach
                </div>
        </div>
              @endforeach
        
        
    </div>
    </div>
     @endforeach
</div>