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
                    <div>Edit Table                             
                    </div>
                </div>
             </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title"></h5>
        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
        
            <form class="" method="post" action="<?php echo e(route('menu.table.update',$detail->id)); ?>" enctype="multipart/form-data">
             <?php echo method_field('PUT'); ?>
               <?php echo csrf_field(); ?>
      
               
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Table Number</label>
                <div class="col-sm-10">
                    <input name="table_number" id="name" minlength="1" maxlength="2" placeholder="Enter table number" type="text" class="form-control" value="<?php echo e($detail->table_number); ?>">
                </div>
            </div>

             <div class="position-relative row form-group">
                <label for="capacity" class="col-sm-2 col-form-label">Capacity</label>
                <div class="col-sm-10">
                    <input name="capacity" id="capacity" minlength="1" maxlength="2" placeholder="Enter capacity" type="text" class="form-control" value="<?php echo e($detail->capacity); ?>">
                </div>
            </div>
           
           <div class="position-relative row form-group">
            <label for="checkbox2" class="col-sm-2 col-form-label">Table Status</label>
            <div class="col-sm-10">
                        <select name="status" id="exampleSelect" class="form-control">
                            <option value="0" <?php echo e($detail->booking_status == 0 ? 'Reserved' : ''); ?> >Reserved</option>
                            <option value="1" <?php echo e($detail->booking_status == 1 ? 'Available' : ''); ?> >Available</option>
                            <option value="2" <?php echo e($detail->booking_status == 2 ? 'Damage' : ''); ?> >Damage</option>
                        </select>
                </div>
            </div>
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
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
    <script>
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/tabledetail/edit.blade.php ENDPATH**/ ?>