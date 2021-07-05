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
                    <div>Category Table
                    </div> 
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="<?php echo e(route('menu.addcategory')); ?>"  class="btn-shadow btn btn-info">
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
                        <div class="card-body"><h5 class="card-title">Category Table</h5>
                            <table class="mb-0 table table-bordered data-table" id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>                                        
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                  </thead>
                                 <tbody id="tablecontents">
                                    <?php
                                    $i=1;
                                    ?>
                                    <?php $__currentLoopData = $model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row1" data-id="<?php echo e($value->id); ?>">
                                        <th scope="row"><?php echo e($i++); ?></th>
                                        <td><?php echo e(ucfirst($value->dish_category)); ?></td>
                                        <td><image src="../category/<?php echo e($value->image); ?>" height="70" width="70"></td>
                                        
                                        <td> <a href="" onclick="if(confirm('Are you sure?'))event.preventDefault(); document.getElementById('status-<?php echo e($value->id); ?>').submit();" class="btn btn-sm btn-<?php echo e(($value->status == '1') ? 'danger' : 'success'); ?>">
                                           <?php echo e(($value->status == '1') ? 'Deactive' : 'Active'); ?>


                                        </a></td>
                                        <td><a href="<?php echo e(route('menu.category.edit',$value->id)); ?>" class="edit" data-info="<?php echo e($value->id); ?>"><i class="pe-7s-note"> </i></a>
                                                                              
                                         <a href="" onclick="if(confirm('Do you want to delete this detail?'))event.preventDefault(); document.getElementById('delete-<?php echo e($value->id); ?>').submit();" class="delete"><i class="pe-7s-trash"> </i></a>
                                          <form id="delete-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('menu.category.destroy', $value->id)); ?>" style="display: none;">
                                          <?php echo csrf_field(); ?>
                                        </form>

                                       
                                          <form id="status-<?php echo e($value->id); ?>" method="post" action="<?php echo e(route('menu.category.status',['id'=>$value->id ,'status'=>$value->status])); ?>" style="display: none;">
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
                 
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
    <script type="text/javascript">
  $(function () {
    // $("#table").DataTable();

    $( "#tablecontents" ).sortable({
      items: "tr",
      cursor: 'move',
      opacity: 0.6,
      update: function() {
          sendOrderToServer();
      }
    });

    function sendOrderToServer() {

      var order = [];
      $('tr.row1').each(function(index,element) {
        order.push({
          id: $(this).attr('data-id'),
          position: index+1
        });
      });

      $.ajax({
        type: "POST", 
        dataType: "json", 
        url: "<?php echo e(url('resturant/sortabledatatable')); ?>",
        data: {
          order:order,
          _token: '<?php echo e(csrf_token()); ?>'
        },
        success: function(response) {
            if (response.status == "success") {
              console.log(response);
            } else {
              console.log(response);
            }
        }
      });

    }
  });

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/category/view.blade.php ENDPATH**/ ?>