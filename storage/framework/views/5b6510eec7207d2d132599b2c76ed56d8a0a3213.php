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
                    <div>Add Employee                             
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
        
        <form class="" action="<?php echo e(route('menu.employee.save')); ?>" method="POST" enctype="multipart/form-data">

               <?php echo csrf_field(); ?>
          
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input name="name" id="name" placeholder="Enter Name" type="text" class="form-control" required>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input name="email" placeholder="Enter email" type="email" class="form-control">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input name="password" placeholder="************" type="password" class="form-control">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="mobile" class="col-sm-2 col-form-label">Contact</label>
                <div class="col-sm-10">
                    <input name="mobile" placeholder="Enter Contact number" type="text" minlength="10" maxlength="10" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" class="form-control" required>
                </div>
            </div>
              <div class="position-relative row form-group">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input name="address" placeholder="Enter Address" type="text" class="form-control" required>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="proof" class="col-sm-2 col-form-label">Proof</label>
                <div class="col-sm-10">
                    <input name="proof" placeholder="Upload" type="file" class="form-control" required>
                </div>
            </div>
           <div class="position-relative row form-group">
            <label for="police_verify" class="col-sm-2 col-form-label">Verification</label>
            <div class="col-sm-10">
                        <select name="police_verify" id="exampleSelect" class="form-control">
                            <option value="0">Pending</option>
                            <option value="1">Done</option>
                        </select>
            </div>
            </div>
            <div class="position-relative row form-group">
                <label for="join_date" class="col-sm-2 col-form-label">Join Date</label>
                <div class="col-sm-10">
                    <input name="join_date" placeholder="Join date" type="date" class="form-control" required>
                </div>
            </div> 
             
            <div class="position-relative row form-group">
                <label for="salary" class="col-sm-2 col-form-label">Salary</label>
                <div class="col-sm-10">
                    <input name="salary" placeholder="Enter Salary" type="number" class="form-control" required>
                </div>
            </div>
            
            <div class="position-relative row form-group">
            <label for="role" class="col-sm-2 col-form-label">Role</label>
            <div class="col-sm-10">
                        <select name="role_id" id="role" class="form-control" required >
                            <option>Select Role</option>
                            <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key->id); ?>"><?php echo e(ucfirst($key->name)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/employee/create.blade.php ENDPATH**/ ?>