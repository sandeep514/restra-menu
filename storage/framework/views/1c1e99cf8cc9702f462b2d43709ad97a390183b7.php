<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title>Resturant</title>
        <link href="<?php echo e(asset('asset/main.css')); ?>" rel="stylesheet">
        <!-- Scripts -->
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>
        
        
       
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
         <script src="<?php echo e(asset('asset/js/main.js')); ?>" defer></script>
        <!-- Styles -->
<style type="text/css">
    
</style>        
    </head>
    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            <div class="app-header header-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                        </button>
                    </span>
                </div>    <div class="app-header__content">
                <div class="app-header-left">
                     <?php if(Auth::user()->role_id!=1): ?>
                    <?php
                     $id=App\Models\Restuarant_list::where('user_id', auth()->user()->id)->select('expiry_date','id')->first();
                      $to = Carbon\Carbon::now();
                      $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $id->expiry_date);
                       $diff_in_months = $to->diffInMonths($from);
                     ?>
                    <a href="<?php echo e(route('menu.list',$id->id)); ?>" target="_blank" class="nav-link">  Preview Menu </a>
                   
                    <span id="edate" class="<?php echo e(($diff_in_months > '1') ?'alert alert-success':'alert alert-danger '); ?>">Membership Expired :<?php echo e(date("d-M-Y", strtotime($id->expiry_date))); ?></span>
                    <?php endif; ?>
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                
                                <?php if(Auth::user()->role_id!=1): ?>
                                <?php
                                $log_id=Auth()->user()->id;
                                $qrcode=App\Models\Restuarant_list::where('user_id', $log_id)->pluck('barcode')->first();
                                
                                ?>
                                <div class="widget-content-left header-user-info mr-3">
                                   <div class="dropdown">
                            <button type="button" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-focus"></span>
                                    <span class="language-icon opacity-8 flag large DE"></span>
                                </span>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu dropdown-menu-right">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner pt-4 pb-4 bg-focus">
                                       
                                        <div class="menu-header-content text-center text-white">
                                            <h6 class="menu-header-subtitle mt-0"> Qrcode</h6>
                                        </div>
                                    </div>
                                </div>
                                 <button type="button" tabindex="0" class="dropdown-item">
                                    
                                 <img src="<?php echo e($qrcode); ?>" alt="barcode" width="100" height="100"/>
                                </button>
                            </div>
                        </div>  
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="widget-content-right">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                                <?php if(Auth::user()->role_id==1): ?>
                                                <img width="42" class="rounded-circle" src="../asset/images/avatars/1.jpg" alt="">
                                                <?php else: ?>
                                                <?php
                                                $image=App\Models\Restuarant_list::where('user_id', $log_id)->pluck('logo')->first();
                                                ?>
                                                <img width="42" class="rounded-circle" src="<?php echo e(asset('images/'.$image)); ?>" alt="">
                                                <?php endif; ?>
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                
                                                <button type="button" tabindex="0" class="dropdown-item">  <a href="<?php echo e(route('logout')); ?>" class="nav-link" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                    <?php echo e(__('Logout')); ?>

                                                </a>
                                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                                    <?php echo csrf_field(); ?>
                                                </form></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-right  ml-3 header-user-info">
                                        <div class="widget-heading">
                                            <?php echo e(ucfirst(Auth::user()->name)); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>        </div>
                    </div>
                </div>
                <div class="app-main">
                    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
            <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <?php if(session()->has('success')): ?>
            <script>
            toastr.success('<?php echo e(session()->get('success')); ?>')
            </script>
            <?php endif; ?>
            <?php echo $__env->yieldContent('modal'); ?>
            <?php echo $__env->yieldContent('script'); ?>
        </body>
    </html><?php /**PATH E:\xampp\htdocs\restaurant-manage\resources\views/layouts/app1.blade.php ENDPATH**/ ?>