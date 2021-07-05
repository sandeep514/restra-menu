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
                    <div>Create Subcategory                             
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
        
        <form class="" method="post" action="<?php echo e(route('menu.subcategory.save')); ?>" enctype="multipart/form-data">
               <?php echo csrf_field(); ?>
           <div class="position-relative row form-group">
            <label for="exampleSelect" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
            <select name="category_id" id="exampleSelect" class="form-control">
                <option value="">Select Dish Category</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($data->id); ?>">
                    <?php echo e($data->dish_category); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            </div>
            </div>
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Sub Category</label>
                <div class="col-sm-10">
                    <input name="dish_subcategory" id="name" placeholder="Subcategory" type="text" class="form-control">
                </div>
            </div>
             <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input name="image" placeholder="select image" type="file" class="form-control" required>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-10">
                    <div class="position-relative form-group">
                        <div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="dish_type[]" id="exampleCustomInline" class="custom-control-input" value="1" checked="">
                                <label class="custom-control-label" for="exampleCustomInline">Vegetarian</label>
                            </div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="dish_type[]" id="exampleCustomInline2" class="custom-control-input" value="0">
                                <label class="custom-control-label" for="exampleCustomInline2">Non Vegetarian</label>
                            </div>
                        </div>
                        </div>                    
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
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/Subcategory/create.blade.php ENDPATH**/ ?>