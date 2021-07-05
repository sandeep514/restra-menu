<?php $__env->startSection('content'); ?>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Seat View
                    </div> 
                </div>               
               </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                          <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                   <div class="badge badge-reserve ml-2">Reserved</div>
                                    <div class="badge bagde-available ml-2">Available</div>
                                    <div class="badge badge-light ml-2">Damage</div>
                                </div>
                            </div>
                        <div class="card-body"><h5 class="card-title">Seat View</h5>
                        <div class="row">
                           <?php $__currentLoopData = $model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php
                           if($value->booking_status=='1')
                           {
                            $bookingstatus='a';
                           }
                           elseif($value->booking_status=='2')
                           {
                             $bookingstatus='d';
                           }
                           else{
                             $bookingstatus='i';
                           }
                           ?> 
                                        <div class="col-md-2">
                                        <?php if($value->capacity=='4'): ?>

                                        <img src="../table_icon/4C<?php echo e($bookingstatus); ?>.png" height="70" width="70">
                                        <?php endif; ?>
                                         <?php if($value->capacity=='6'): ?>
                                         <img src="../table_icon/6C<?php echo e($bookingstatus); ?>.png" height="70" width="70">
                                        <?php endif; ?>
                                        <div class="text-block">
                                            
                                            <span>Table No.<?php echo e($value->table_number); ?></span>
                                          </div>
                                      </div>
                                        
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div></div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-left">
                 
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
     <?php $__env->startSection('script'); ?>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/tableReserveView/view.blade.php ENDPATH**/ ?>