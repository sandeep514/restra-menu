<div class="container">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row cat<?php echo e($k); ?>">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center
                ">
                <div class="page-section bgcolor-info">
                    <h1 class="page-title"><?php echo e(ucfirst($k)); ?></h1>
                </div>
            </div>
        </div>
        <div class="row cat<?php echo e($k); ?>">
            <!-- starter -->
            <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12 ">

                <?php $__currentLoopData = $sub; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat=>$scategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="menu-block ">
                   <h2 class="menu-title"><?php echo e(ucfirst($subcat)); ?></h2> 
                    <div class="menu-content">
                        <?php $__currentLoopData = $scategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menukey=>$menuvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row ">
                        	<div class="col-lg-1 col-md-2 col-sm-3 col-xs-3" style="float: right;">
                        	<?php if($menuvalue->best_seller=='1'): ?>
							<img src="<?php echo e(asset('/images/seller.jpg')); ?>" alt=""/>	
							<?php endif; ?>                                  
						</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                <div class="dish-img"><a data-fancybox="gallery" href="../category/<?php echo e($menuvalue->image); ?>"  data-caption="<?php echo e(ucfirst($menuvalue->description)); ?><br> &nbsp;<?php echo e(ucfirst($menuvalue->menu_name)); ?><?php if($menuvalue->foodstatus == '1'): ?>)

                            <img src='<?php echo e(asset('/category/veg.png')); ?>' style='height:20px;width:20px' alt='' />
                            <?php else: ?>
                            <img src='<?php echo e(asset('/category/nonveg.png')); ?>' style='height:20px;width:20px' alt='' />
                            <?php endif; ?><br> <?php for( $j = 1 ; $j <= $menuvalue->rating; $j++ ): ?>
                            <i class='fa fa-star text-warning' style='font-size:20px;'></i>
                            <?php endfor; ?>
                        " >                       
                        <img src="<?php echo e(asset('category/'.$menuvalue->image)); ?>" class="img-circle" alt="" /></a>
                          
                         
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-7">
                            <div class="dish-content">
                                <p class="dish-title"><?php echo e(ucfirst($menuvalue->menu_name)); ?> 
                                  <?php if($menuvalue->foodstatus == '1'): ?>
                                      <img src="<?php echo e(asset('/category/veg.png')); ?>"  width="15px;" class="veg-cls"/>
				                        <?php else: ?>
				                                  <img src="<?php echo e(asset('/category/nonveg.png')); ?>" width="15px;" class="veg-cls"/>                       
				                        <?php endif; ?>  
				                       </p>

                                <span class="dish-meta"><?php echo e(ucfirst($menuvalue->description)); ?></span>
                                <span class="checked">
                                 <?php for( $j = 1 ; $j <= $menuvalue->rating; $j++ ): ?>
                                <i class="fa fa-star text-warning" style="font-size:15px;"></i>
                                <?php endfor; ?>
                                </span>
                                

                              <span class="text-left <?php echo e(($menuvalue->chef_special == '1') ? 'font-setting' : ''); ?>"><?php echo e(($menuvalue->chef_special == '1') ? 'Chef Special' : ''); ?></span>
                              </div>
                            
                            
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                              <?php if($menuvalue->discount==0): ?>
                              <div class="dish-price">
                                    <p>₹<?php echo e($menuvalue->price); ?></p>
                                </div>
                              <?php else: ?>
                              <div class="dish-price">
                                <span class="discount">₹<?php echo e($menuvalue->discount); ?></span>
                                    <p><strike>₹<?php echo e($menuvalue->price); ?></strike></p>
                                </div>
                                <?php endif; ?>
                          </div>  

                    </div>               
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
        </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        
    </div>
    </div>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/layouts/filter.blade.php ENDPATH**/ ?>