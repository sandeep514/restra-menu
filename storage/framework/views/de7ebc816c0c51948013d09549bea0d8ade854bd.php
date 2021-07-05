<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar"> <span class="hamburger-box">
                    <span class="hamburger-inner"></span> </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav"> <span class="hamburger-box">
                    <span class="hamburger-inner"></span> </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu"> <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span> </button>
            </span>
        </div>
        <div class="scrollbar-sidebar ps ps--active-y">
            <div class="app-sidebar__inner">
                <ul class="vertical-nav-menu">
                    
                   <?php if(Auth::user()->role_id==1): ?>
                   <li class="mm-active">
                        <a href="javascript:void(0)"> <i class="metismenu-icon pe-7s-diamond"></i> Restaurant <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> </a>
                        <ul>
                            <li>
                                <a href="<?php echo e(route('admin.resturant')); ?>"> <i class="metismenu-icon"></i> Add Restaurant </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admin.home')); ?>"> <i class="metismenu-icon">
                                </i>View Restaurant </a>
                            </li></ul>
                    </li>
                    <li class="mm-active">
                        <a href="javascript:void(0)"> <i class="metismenu-icon pe-7s-diamond"></i> Roles <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> </a>
                        <ul>
                            <li>
                                <a href="<?php echo e(route('admin.role')); ?>"> <i class="metismenu-icon"></i> Role List </a>
                            </li>
                        
                        </ul>
                    </li>
                    <?php endif; ?>
                     <?php if(Auth::user()->role_id==2): ?>
                     
                        <li class="mm-active">
                        <a href="javascript:void(0)"> <i class="metismenu-icon pe-7s-diamond"></i> Dashhboard <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> </a>
                        <ul>
                            <li>
                                <a href="<?php echo e(route('manager.dashboard')); ?>"> <i class="metismenu-icon">
                                </i>Attendance </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('menu.tableseatview')); ?>"> <i class="metismenu-icon">
                                </i>Tables</a>
                            </li>
                        </ul>
                      </li>
                        <li class="">
                        <a href="javascript:void(0)"> <i class="metismenu-icon pe-7s-users"></i> Employee <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> </a>
                        <ul>
                            <li>
                                <a href="<?php echo e(route('menu.addemployee')); ?>"> <i class="metismenu-icon"></i> Add Employee</a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('menu.employeeview')); ?>"> <i class="metismenu-icon"></i>List Employee </a>
                            </li>
                        </ul>
                    </li>
                    <li class="mm-active">
                        <a href="javascript:void(0)"> <i class="metismenu-icon pe-7s-diamond"></i> Category <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> </a>
                        <ul>
                            <li>
                                <a href="<?php echo e(route('menu.addcategory')); ?>"> <i class="metismenu-icon"></i>Add category </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('menu.categoryview')); ?>"> <i class="metismenu-icon">
                                </i>view category  </a>
                            </li>
                           </ul>
                           </li> 
                        <li class="mm-active">
                        <a href="javascript:void(0)"> <i class="metismenu-icon pe-7s-diamond"></i> Sub Category <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> </a>
                        <ul>
                            <li>
                                <a href="<?php echo e(route('menu.addsubcategory')); ?>"> <i class="metismenu-icon">
                                </i>Add subcategory </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('menu.subcategoryview')); ?>"> <i class="metismenu-icon">
                                </i>View subcategory </a>
                            </li>
                        </ul>
                    </li>
                     
                        <li class="mm-active">
                        <a href="javascript:void(0)"> <i class="metismenu-icon pe-7s-diamond"></i> Product <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> </a>
                        <ul>
                            <li>
                                <a href="<?php echo e(route('menu.addmenu')); ?>"> <i class="metismenu-icon"></i> Add product </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('menu.view')); ?>"> <i class="metismenu-icon">
                                </i>View product </a>
                            </li></ul>
                    </li>
                     <li class="mm-active">
                        <a href="javascript:void(0)"> <i class="metismenu-icon pe-7s-diamond"></i> Manage Table <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> </a>
                        <ul>
                            <li>
                                <a href="<?php echo e(route('menu.addtable')); ?>"> <i class="metismenu-icon">
                                </i>Add table </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('menu.tableview')); ?>"> <i class="metismenu-icon">
                                </i>View table </a>
                            </li>
                        </ul>
                    </li>
                   
                     
                   

                    <?php endif; ?>
                    
                    
                </ul>
            </div>
        </div>
    </div><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>