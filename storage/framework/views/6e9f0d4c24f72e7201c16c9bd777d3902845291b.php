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
                    <div>Edit Menu                             
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
        
         <form class="" method="post" action="<?php echo e(route('menu.update',$detail->id)); ?>"  enctype="multipart/form-data">
            <?php echo method_field('PUT'); ?>
               <?php echo csrf_field(); ?>
               <input type="hidden"  id="sub_id" name="sub_id" value="<?php echo e($detail->subcategory_id); ?>">
           <div class="position-relative row form-group">
            <label for="dish_category" class="col-sm-2 col-form-label">Dish Category</label>
                <div class="col-sm-10">
                    <select  id="dish_category" class="form-control" name="dish_category">
                <option value="">Select Dish Category</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <option value="<?php echo e($data->id); ?>" <?php echo e($detail->category_id == $data->id ? 'selected' : ''); ?>>
                    <?php echo e($data->dish_category); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            </div>
            </div>
            <div class="position-relative row form-group">
             <label for="dish_subcategory" class="col-sm-2 col-form-label">Dish Subcategory</label>
                <div class="col-sm-10">

                    <select  id="dish_subcategory" class="form-control" name="dish_subcategory">

                    </select>
                </div>
            </div>
          
            <div class="position-relative row form-group">
                <label for="menu_name" class="col-sm-2 col-form-label">Menu Name</label>
                <div class="col-sm-10">
                    <input type="text" id="menu_name" value="<?php echo e($detail->menu_name); ?>" name="menu_name" placeholder="Enter  Name" class="form-control name_list" />
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <?php if($detail->image): ?>
                        <img id="original" src="<?php echo e(url('/category/'.$detail->image)); ?>" height="70" width="70">
                    <?php endif; ?>
                    <input name="image" placeholder="select image" type="file" class="form-control"  >
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="price" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input type="text" name="price" value="<?php echo e($detail->price); ?>" id="price"  placeholder="Enter price" class="form-control name_list" onkeypress ="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))"/>
                </div>
            </div> 
            <div class="position-relative row form-group">
             <label for="rating" class="col-sm-2 col-form-label">Rating</label>
                <div class="col-sm-10">

                    <select name="rating" id="rating" class="form-control name_list">
                                        <option value="">Select Rating</option>
                                        <option value="1" <?php echo e($detail->rating == 1 ? 'selected' : ''); ?>>1</option>
                                        <option value="2" <?php echo e($detail->rating == 2? 'selected' : ''); ?>>2</option>
                                        <option value="3" <?php echo e($detail->rating == 3 ? 'selected' : ''); ?>>3</option>
                                        <option value="4" <?php echo e($detail->rating == 4 ? 'selected' : ''); ?>>4</option>
                                        <option value="5" <?php echo e($detail->rating == 5 ? 'selected' : ''); ?>>5</option>
                     </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="dish_subcategory" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" maxlength="250" cols="45" class="form-control" ><?php echo e($detail->description); ?> </textarea>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="dish_subcategory" class="col-sm-2 col-form-label">Discount</label>
                <div class="col-sm-10">
                    <input type="text" name="discount"  class="form-control name_list" value="<?php echo e($detail->discount); ?>" onkeypress ="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))"/>
                </div>
            </div>
             <div class="position-relative row form-group">
                <label  class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-10">
                    <div class="position-relative form-check">
                        <label class="form-check-label">
                            <input name="foodstatus" type="radio" class="form-check-input" value="1" <?php echo e($detail->foodstatus == 1 ? 'checked' : ''); ?>>
                            Vegetarian
                        </label>
                    </div>
                    <div class="position-relative form-check">
                        <label class="form-check-label">
                            <input name="foodstatus" type="radio" class="form-check-input" value="2" <?php echo e($detail->foodstatus == 2 ? 'checked' : ''); ?>>
                            Non Vegetarian
                        </label>
                    </div>
                    
                    </div>
            </div>


           
               
             
            <div class="position-relative row form-check">
               <div class="col-sm-10 offset-sm-2">
                    <button class="btn btn-primary">Submit</button>
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
        $(document).ready(function () {

            $('#dish_category').on('change', function () {
                subcategory();
            });

            function subcategory(){
                var idcat = $('#dish_category').val();
                var subcat= $('#sub_id').val();
                // alert(idcat);
                $("#dish_subcategory").html('');
                $.ajax({
                    url: "<?php echo e(url('/fetch-subcategory')); ?>",
                    type: "POST",
                    data: {
                        category_id: idcat,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#dish_subcategory').html('<option value="">Select subcategory</option>');
                        $.each(result.Subcategories, function (key, value) {
                            if(value.id==subcat){
                            $("#dish_subcategory").append('<option value="' + value
                                .id + '" selected>' + value.dish_subcategory +'</option>');
                        }
                        else{
                            $("#dish_subcategory").append('<option value="' + value
                                .id + '">' + value.dish_subcategory +'</option>');
                        }
                        });
                       
                    }
                }); 
            }

        subcategory(); 

        });

    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/menu/edit.blade.php ENDPATH**/ ?>