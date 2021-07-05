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
                    <div>Menu Table
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                       
                        <a href="<?php echo e(route('menu.addmenu')); ?>"  class="btn-shadow btn btn-info">
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
                        <div class="card-body" style=""><h5 class="card-title">Menu Table</h5>
                             <div class="table-responsive">
                            <table class="table table-bordered " id="example" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Today's Special</th>
                                        <th>Best Seller</th>
                                        <th>Category</th>
                                        <th>Sub</th>
                                        <th>Image</th>
                                        <th>Item</th>
                                        <th>Type</th>
                                        <th>₹</th>
                                        <th>Discount</th>
                                        <th width="30%">Description</th>
                                        <th>Rating</th>
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
                                        
                                        
                                        <td> <a href="javascript:void(0)" onclick="document.getElementById('specialstatus-<?php echo e($value->id); ?>').submit();" class="btn btn-sm ">
                                          
                                           <?php if(($value['chef_special'] == '1')): ?>
                                           <input type="checkbox" checked/>
                                           <?php else: ?>
                                          <input type="checkbox" />
                                          <?php endif; ?>

                                           

                                        </a>
                                          <form id="specialstatus-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('menu.specialstatus',['id'=>$value->id ,'status'=>$value->chef_special])); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form></td>

                                        <td> <a href="javascript:void(0)" onclick="document.getElementById('sellerstatus-<?php echo e($value->id); ?>').submit();" class="btn btn-sm ">
                                          
                                           <?php if(($value['best_seller'] == '1')): ?>
                                           <input type="checkbox" checked/>
                                           <?php else: ?>
                                          <input type="checkbox" />
                                          <?php endif; ?>

                                           

                                        </a>
                                          <form id="sellerstatus-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('menu.sellerstatus',['id'=>$value->id ,'status'=>$value->best_seller])); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form></td>

                                        <td><?php echo e(App\Models\Categories::find($value->category_id)->dish_category); ?></td>
                                        <td><?php echo e(App\Models\Subcategories::find($value->subcategory_id)->dish_subcategory); ?></td>
                                        <?php if(!empty($value->image)): ?>
                                        <td><img src="../category/<?php echo e($value->image); ?>" height="70" width="70"></td>
                                        <?php else: ?>    
                                        <td><img src="../category/no.png" height="70" width="70"></td>
                                        <?php endif; ?>                                            
                                         <td><?php echo e($value->menu_name); ?></td>

                                        
                                        <td> <a href="javascript:void(0)" onclick="document.getElementById('fstatus-<?php echo e($value->id); ?>').submit();" class="btn btn-sm btn-<?php echo e(($value['foodstatus'] == '1') ? 'success' : 'danger'); ?>">
                                           <?php echo e(($value['foodstatus'] == '1') ? 'Veg' : 'Non-Veg '); ?>


                                        </a>
                                          <form id="fstatus-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('menu.foodstatus',['id'=>$value->id ,'status'=>$value->foodstatus])); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form></td>
                                        <td><?php echo e($value->price); ?></td>
                                        <td><?php echo e($value->discount); ?></td>
                                        <td data-toggle="tooltip"
                                                    data-placement="left" title="<?php echo e($value->description); ?>"> <?php echo e(Illuminate\Support\Str::limit($value->description, 25, '...')); ?> </td>
                                        <td>
                                             <?php for( $j = 1 ; $j <= $value->rating; $j++ ): ?>
                                                    <i class="fa fa-star text-warning" style="font-size:10px;"></i>
                                                <?php endfor; ?>
                                        </td>
                                        <td> <a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-<?php echo e($value->id); ?>').submit();" class="btn btn-sm btn-<?php echo e(($value['status'] == '1') ? 'danger' : 'success'); ?>">
                                           <?php echo e(($value['status'] == '1') ? 'Inactive' : 'Active'); ?>


                                        </a>
                                          <form id="status-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('menu.status',['id'=>$value->id ,'status'=>$value->status])); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form></td>
                                        
                                        <td><a href="<?php echo e(route('menu.edit',$value->id)); ?>" class="edit" data-info="<?php echo e($value->id); ?>">
                                        <i class="pe-7s-note"> </i></a>
                                                                              
                                         <a href="" onclick="if(confirm('Do you want to delete this detail?'))event.preventDefault(); document.getElementById('delete-<?php echo e($value->id); ?>').submit();" class="delete"><i class="pe-7s-trash"> </i></a>
                                          <form id="delete-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('menu.destroy', $value->id)); ?>" style="display: none;">
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
    </div>
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="<?php echo e(route('logout')); ?>" class="nav-link" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                               <?php echo e(__('Logout')); ?>

                            </a>
                             <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="GET" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>

                                   
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
     <?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function () {
             $('#example').dataTable({
                 "autoWidth":false,
                 "columnDefs": [ { "width": "30px", "targets": 5 }],
             });

             
        });
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/menu/view.blade.php ENDPATH**/ ?>