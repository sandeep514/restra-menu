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
                     <div>Subcategory Table
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="<?php echo e(route('menu.addsubcategory')); ?>"  class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-business-time fa-w-20"></i>
                        </span>
                        Add
                        </a>                        
                    </div> 
                </div>    </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body"><h5 class="card-title">SubCategory Table</h5>
                            <table class="mb-0 table table-bordered data-table" id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Dish Subcategory</th>
                                        <th>Type</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                  </thead>
                                 <tbody>
                                    <?php
                                    $i=1;
                                    ?>
                                    <?php $__currentLoopData = $model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php if(!empty($model)): ?>
                                        <th scope="row"><?php echo e($i++); ?></th>
                                        <td><?php echo e(ucfirst(App\Models\Categories::find($value->category_id)->dish_category)); ?></td>
                                         <td><?php echo e(ucfirst($value->dish_subcategory)); ?></td>
                                        <td><?php echo e(($value->dish_type =='1') ? 'Vegetarian' : 'Non Vegetarian'); ?></td>
                                         <td><img src="../category/<?php echo e($value->image); ?>" height="70" width="70"></td>
                                        <td><a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-<?php echo e($value->id); ?>').submit();" class="btn btn-sm  btn-<?php echo e(($value->status == '1') ? 'danger' : 'success'); ?>">
                                           <?php echo e(($value->status == '1') ? 'Deactive' : 'Active'); ?>


                                        </a>
                                          <form id="status-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('menu.subcategory.status',['id'=>$value->id ,'status'=>$value->status])); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form> </td>


                                       
                                        <td><a href="<?php echo e(route('menu.subcategory.edit',$value->id)); ?>" data-info="<?php echo e($value->id); ?>" class="edit"><i class="pe-7s-note"> </i></a>
                                                                              
                                         <a href="" onclick="if(confirm('Do you want to delete this detail?'))event.preventDefault(); document.getElementById('delete-<?php echo e($value->id); ?>').submit();" class="delete"><i class="pe-7s-trash"> </i></a>
                                          <form id="delete-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('menu.subcategory.destroy', $value->id)); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form>

                                        
                                    </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
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
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/Subcategory/view.blade.php ENDPATH**/ ?>