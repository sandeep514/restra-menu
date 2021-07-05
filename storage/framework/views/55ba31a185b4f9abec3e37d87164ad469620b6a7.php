<?php $__env->startSection('content'); ?>
<style>
    a.disabled {
  pointer-events: none;
  cursor: default;
}
</style>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Attendance Table
                    </div>
                  
                </div>

              </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body"><h5 class="card-title">Attendance Table</h5>
                            <table class="mb-0 table table-bordered data-table" id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Designation</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>In/Out Time</th>
                                        <th>Duration</th>
                                        <th>Attendance</th>

                                    </tr>
                                  </thead>
                                 <tbody>
                                    <?php
                                    $i=1;
                                    $j=0;
                                    ?>
                                    <?php $__currentLoopData = $model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"><?php echo e($i++); ?></th>
                                        <td><?php echo e(ucfirst($key['name'])); ?></td>
                                        <td><?php echo e($key['email']); ?></td>
                                       
                                        <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys=>$values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($values->id==$key['role_id']): ?>
                                        
                                        <td><?php echo e(ucfirst($values->name)); ?></td>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                        <td> <a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-<?php echo e($key['id']); ?>').submit();" class="btn btn-sm btn-<?php echo e(($key['status'] == '1') ? 'danger' : 'success'); ?>">
                                           <?php echo e(($key['status'] == '1') ? 'Deactive' : 'Active'); ?>


                                        </a>
                                          <form id="status-<?php echo e($key['id']); ?>" method="post" action="<?php echo e(route('menu.employee.status',['id'=>$key['id'] ,'status'=>$key['status']])); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form></td>

                                       <?php if(!empty($key['attend'])): ?>                                    
                                       <?php 
                                      if(!empty($key['attend']['time_end'])){
                                        $endTime = explode('T',$key['attend']['time_end']);
                                        $endDTime = \Carbon\Carbon::parse($endTime[0].' '.$endTime[1]);
                                       }
                                       else{
                                        $endDTime = \Carbon\Carbon::now();
                                        }

                                        // $startTime = explode('T',$key['attend']['time_start']);
                                       

                                       ?>
                                        <td><span>
                                         <?php
                                         $curDate=\Carbon\Carbon::now()->format('Y-m-d');
                                         if($key['attend']['attend_date']  == $curDate){
                                              echo $key['attend']['attend_date'] ;
                                        $startDTime = \Carbon\Carbon::parse($key['attend']['time_start']);
                                        $totalDuration = $endDTime->diff($startDTime)->format('%H.%I');

                                         }
                                         else
                                         {
                                         echo $curDate;

                                        $totalDuration = 00.00;
                                         }
                                         ?>       
                                        </span></td>
                                        <td>    
                                        <?php if($key['attend']['punch']=='in'): ?>
                                        <a href="javascript:void(0)" onclick="exit_time(<?php echo e($key['id']); ?>)" data-info="<?php echo e($key['id']); ?>" class="btn btn-sm btn-info" id="out_time<?php echo e($key['id']); ?>">Out time</a>
                                        <?php else: ?>
                                        <a href="javascript:void(0)" onclick="enter_time(<?php echo e($key['id']); ?>)" id="in_time<?php echo e($key['id']); ?>" data-info="<?php echo e($key['id']); ?>" class="btn btn-sm btn-info">In time</a>
                                        <?php endif; ?>
                                      </td>
                                      <td><?php echo e((empty($key['attend']['duration']) ? $totalDuration : $key['attend']['duration'] )); ?></td>
                                      <?php else: ?>
                                      <td><span><?php echo e(\Carbon\Carbon::today()->format('Y-m-d')); ?></span></td>
                                      <td><a href="javascript:void(0)" onclick="enter_time(<?php echo e($key['id']); ?>)" id="in_time<?php echo e($key['id']); ?>" data-info="<?php echo e($key['id']); ?>" class="btn btn-sm btn-info">In time</a>
                                        </td>
                                        <td></td>
                                      <?php endif; ?>
                                    <td> <a href="<?php echo e(route('employee.all.attend',['id'=>$key['id']])); ?>" class="btn btn-sm">View</a></td>
                                    
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
     <?php $__env->startSection('modal'); ?>
       <div class="modal fade" id="in_timemodal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="in-time">In time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('employee.intime')); ?>"  method="POST">
                     <?php echo csrf_field(); ?>
            <div class="modal-body">
                
                    <input type="hidden" name="employ_id" value="">
                    <input type="hidden" name="punch" value="in">
                    
                     <div class="position-relative row form-group">
                <label for="time_start" class="col-sm-3 col-form-label">In time</label>
                <div class="col-sm-8">
                    <input name="time_start" type="datetime-local" class="form-control"  value=<?php echo e(\Carbon\Carbon::now()); ?> required>
                </div>
            </div> 
            
                   <input type="hidden" name="attend_date"  class="form-control" value=<?php echo e(\Carbon\Carbon::today()); ?> readonly />
            

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
                 </form>   
        </div>
    </div>
</div>
 <div class="modal fade" id="out_timemodal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="out-time">Out time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form action="<?php echo e(route('employee.outtime')); ?>"  method="POST">

             <?php echo method_field('PUT'); ?>
                <?php echo csrf_field(); ?>
            <div class="modal-body">               
                     
                     <input type="hidden" name="employ_id" value="" >
                     <input type="hidden" name="punch" value="out">
                     <div class="position-relative row form-group">
                <label for="time_end" class="col-sm-3 col-form-label">Out time</label>
                <div class="col-sm-8">
                    <input name="time_end"  type="datetime-local" class="form-control"  value=<?php echo e(\Carbon\Carbon::now()); ?> required>
                </div>
            </div> 
                   <input type="hidden" name="attend_date"  class="form-control" value=<?php echo e(\Carbon\Carbon::today()); ?> readonly>
                 

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
</form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



     <?php $__env->startSection('script'); ?>
     <script type="text/javascript">
        function enter_time($id){

         $('#in_timemodal').modal();
         $('#in_time'+$id).data('info');
         $('input[name=employ_id]').val($id);

       }

        function exit_time($id){
         $('#out_timemodal').modal('show');
         $('#out_time'+$id).data('info');
        $('input[name=employ_id]').val($id);
       }
     $(document).ready(function () {

    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/dashboard.blade.php ENDPATH**/ ?>