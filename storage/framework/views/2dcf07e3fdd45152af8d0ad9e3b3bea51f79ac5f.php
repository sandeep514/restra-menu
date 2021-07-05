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
                    <div>Add Menu                             
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
        
        <form class="" method="post"   enctype="multipart/form-data" action=<?php echo e(route('menu.save')); ?>>
               <?php echo csrf_field(); ?>
            <div class="position-relative row form-group">
                <label for="dish_category" class="col-sm-2 col-form-label">Dish Category</label>
                <div class="col-sm-10">
                    <select  id="dish_category" class="form-control" name="dish_category">
                          <option value="">Select Category</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($data->id); ?>" data-value="<?php echo e($data->dish_category); ?>">
                                <?php echo e($data->dish_category); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="position-relative row form-group dish_subcategory">
                <label for="dish_subcategory" class="col-sm-2 col-form-label">Dish Subcategory</label>
                <div class="col-sm-10">
                    <select  id="dish_subcategory" class="form-control" name="dish_subcategory"></select>
                </div>
            </div>
            
           
                <div class="table-responsive-sm">
                    <table class="table table-striped" id="new">
                        <thead>
                            <tr>                                
                                 <th>Name</th>
                                 <th>Image</th>
                                 <th>Price</th>
                                 <th>Discount</th>
                                 <th>Rating</th>
                                 <th>Description</th>
                                 <th>Action
                            </tr>
                        </thead>
                          <tbody id="tdata">
                            <tr>
                                <td><input type="text" name="menu_name[]" placeholder="Enter  Name" class="form-control name_list" /></td>
                                <td><input type="file" name="menu_image[]" class="form-control name_list" multiple /></td>
                                <td><input type="text" name="price[]" placeholder="Enter price" class="form-control name_list" onkeypress="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))"/></td>
                                <td><input type="text" name="discount[]" placeholder="Enter Discount" value="0" class="form-control name_list" onkeypress ="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))"/></td>
                                <td>
                                     <select name="rating[]" id="exampleSelect" class="form-control name_list">
                                        <option value="">Select Rating</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </td>
                                <td><textarea name="description[]" maxlength="250" class="form-control"></textarea></td>
                                <td> 
                    <div class="position-relative form-check">
                        <label class="form-check-label">
                            <input name="foodstatus[0]" type="radio" class="form-check-input" value="1" checked>
                            Vegetarian
                        </label>
                    </div>
                    <div class="position-relative form-check">
                        <label class="form-check-label">
                            <input name="foodstatus[0]" type="radio" class="form-check-input" value="2">
                            Non Veg
                        </label> 
                    </div>
                </td>
                                 <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td> 
                            </tr>
                          </tbody>
                         </table>
                         </div> 


          
           
             
            <div class="position-relative row form-check">
                <div class="col-sm-5 ">
                    <button class="btn btn-primary btn-block">Submit</button>
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
                var idcat = this.value;
                var catname = $(this).data('value');

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
                        console.log(result.Subcategories.length);
                         if(result.Subcategories.length>0){
                        $('#dish_subcategory').html('<option value="">Select subcategory</option>');
                       $('.dish_subcategory').show();
                        $.each(result.Subcategories, function (key, value) {
                            $("#dish_subcategory").append('<option value="' + value
                                .id + '">' + value.dish_subcategory +'</option>');

                        });
                    }
                    else{
                       $('.dish_subcategory').hide();
                    }
                       
                }
                  
            });
            });
            var i=1;
            var k=0;
            var m=0;
            $("#add").click(function(){
                i++;
                k++;
                m++;
            event.preventDefault();
            $("#new").append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="menu_name[]" placeholder="Enter Name" class="form-control name_list" /></td><td><input type="file" name="menu_image[]" class="form-control name_list" multiple/></td><td><input type="text" name="price[]" placeholder="Enter price" class="form-control name_list" onkeypress="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))"/></td> <td><input type="text" name="discount[]" placeholder="Enter Discount" class="form-control name_list" onkeypress="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)))"/></td><td> <select name="rating[]" id="exampleSelect" class="form-control name_list"> <option value="">Select Rating</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> </select> </td><td><textarea name="description[]" maxlength="250" class="form-control"></textarea></td><td><div class="position-relative form-check"> <label class="form-check-label"> <input name="foodstatus['+k+']" type="radio" class="form-check-input" value="1" checked> Vegetarian </label></div><div class="position-relative form-check"> <label class="form-check-label"> <input name="foodstatus['+m+']" type="radio" class="form-check-input" value="2"> Non Veg </label></div></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
          
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      
         $("input:radio[value='1'][name='foodstatus']").prop('checked',true);
        });

    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/manager/menu/create.blade.php ENDPATH**/ ?>