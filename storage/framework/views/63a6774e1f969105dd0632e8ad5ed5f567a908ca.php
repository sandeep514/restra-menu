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
                    <div>Restaurant Table
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="<?php echo e(route('admin.resturant')); ?>"  class="btn-shadow btn btn-info">
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
                        <div class="card-body"><h5 class="card-title">restaurant Table</h5>
                            <table class="mb-0 table table-bordered data-table " id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Expiry Date</th>
                                        <th>Location</th>
                                        <th>Contact</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>Barcode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                    <?php 
                                    $i=1;
                                    ?>
                                    <?php $__currentLoopData = $model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        
                                          $to = Carbon\Carbon::now();
                                          $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $value->expiry_date);
                                           $diff_in_months = $to->diffInMonths($from);
                                   ?>
                                    <tr class="<?php echo e(($diff_in_months > '1') ?'':'alert alert-danger '); ?>">
                                        <th scope="row"><?php echo e($i++); ?></th>
                                        <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle" src="../images/<?php echo e($value->logo); ?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading"><?php echo e(ucfirst($value->name)); ?></div>
                                                    <div class="widget-subheading opacity-7"><?php echo e($value->email); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                        
                                        <td><?php echo e(date("Y-m-d", strtotime($value->expiry_date))); ?></td>
                                        <td data-toggle="tooltip"
                                                    data-placement="left" title="<?php echo e(ucfirst($value->location)); ?>"> <?php echo e(Illuminate\Support\Str::limit($value->location, 25, '...')); ?> </td>
                                        
                                        <td><?php echo e($value->contact); ?></td>
                                        <td><?php echo e(App\Models\Country::find($value->country)->name); ?></td>
                                        <td><?php echo e(App\Models\State::find($value->state)->name); ?></td>
                                        
                                        
                                        
                                        <td><img src="<?php echo e($value->barcode); ?>" alt="barcode" width="70" height="70"/></td>
                                        <td><a href="<?php echo e(route('admin.resturant.edit',$value->id)); ?>" data-info="<?php echo e($value->id); ?>" class="edit">
                                       <i class="pe-7s-note"> </i></a>
                                                                              
                                         <a href="" onclick="if(confirm('Do you want to delete this detail?'))event.preventDefault(); document.getElementById('delete-<?php echo e($value->id); ?>').submit();"  class="delete"><i class="pe-7s-trash"> </i></a></a>
                                          <form id="delete-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('admin.resturant.destroy', $value->id)); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form>

                                        <a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-<?php echo e($value->id); ?>').submit();" class="btn btn-sm btn-<?php echo e(($value->status == '1') ? 'danger' : 'success'); ?>">
                                           <?php echo e(($value->status == '1') ? 'Deactive' : 'Active'); ?>


                                        </a>
                                          <form id="status-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('admin.resturant.status',['id'=>$value->id ,'status'=>$value->status])); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form>
                                    </td>
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
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/admin/home.blade.php ENDPATH**/ ?>