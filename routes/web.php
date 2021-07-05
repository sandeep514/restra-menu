<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Main;
use App\Http\Controllers\Admin\Roles;
use App\Http\Controllers\Manager\Atendance;
use App\Http\Controllers\Manager\Menu;
use App\Http\Controllers\Manager\Category;
use App\Http\Controllers\Manager\Subcategory;
use App\Http\Controllers\Manager\Employees;
use App\Http\Controllers\Manager\TableController;

 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 
// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::GET('/', function () {
    return view('welcome');
});
 
Auth::routes();

 Route::group(['middleware'=>'is_admin'], function(){
Route::get('admin/home', [Main::class, 'index'])->name('admin.home');
Route::get('country-list', [Main::class, 'index']);
Route::post('fetch-states', [Main::class, 'fetchState']);
Route::post('fetch-cities', [Main::class, 'fetchCity']);
Route::get('/admin/edit/{id}', [Main::class, 'editresturant'])->name('admin.resturant.edit');
Route::get('admin/profile', [Main::class, 'resturant_profile'])->name('profile');

Route::get('password/reset', [ForgotPasswordController::class,'showLinkRequestForm'])->name('password.reset');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset.token');
Route::post('password/reset', [ResetPasswordController::class,'reset']);



Route::post('store', [Main::class, 'store'])->name('admin.resturant.save');
Route::put('edit/{id}', [Main::class, 'edit'])->name('admin.resturant.update');
Route::post('delete/{id}', [Main::class, 'destroy'])->name('admin.resturant.destroy');
Route::post('status/{id}/{status}', [Main::class, 'status'])->name('admin.resturant.status');
Route::get('/admin/create', [Main::class, 'addresturant'])->name('admin.resturant');
// role
Route::get('/admin/role', [Roles::class, 'index'])->name('admin.role');
// create
Route::get('/admin/create-role', [Roles::class, 'roleAdd'])->name('admin.role.create');
Route::post('/admin/store-role', [Roles::class, 'roleStore'])->name('admin.role.save');
// edit
Route::get('/admin/update-role/{id}', [Roles::class, 'roleEdit'])->name('admin.role.edit');
Route::put('/admin/edit-role/{id}', [Roles::class, 'editrole'])->name('admin.role.update');
// delete
Route::post('/admin/role-delete/{id}', [Roles::class, 'roledestroy'])->name('admin.role.destroy');
Route::post('/admin/role-status/{id}/{status}', [Roles::class, 'rolestatus'])->name('admin.role.status');

// Route::get('/admin/employee', [Main::class, 'listemployee'])->name('admin.employ');

});  

Route::group(['middleware'=>'manager'], function(){
Route::get('resturant/home', [Atendance::class, 'index'])->name('manager.dashboard');

// attendance
Route::post('/resturant/employee-intime', [Atendance::class, 'intime'])->name('employee.intime');
Route::put('/resturant/employee-outtime', [Atendance::class, 'outtime'])->name('employee.outtime');

Route::get('/resturant/attendance_all/{id}', [Atendance::class, 'viewAttendanceAll'])->name('employee.all.attend');
Route::get('/resturant/attendance/{id}/{month}', [Atendance::class, 'viewAttendance'])->name('employee.attend');

// end
//create
Route::get('/resturant/create-menu', [Menu::class, 'menuAdd'])->name('menu.addmenu');
Route::post('fetch-subcategory', [Menu::class, 'fetchsubcategory']);

Route::post('/resturant/store-menu', [Menu::class, 'menuStore'])->name('menu.save');
//edit
Route::get('/resturant/update-menu/{id}', [Menu::class, 'menuEdit'])->name('menu.edit');
Route::put('/resturant/edit-menu/{id}', [Menu::class, 'editmenu'])->name('menu.update');
// delete
Route::post('/resturant/menu-delete/{id}', [Menu::class, 'menudestroy'])->name('menu.destroy');

Route::post('/resturant/menu-status/{id}/{status}', [Menu::class, 'menustatus'])->name('menu.status');
Route::post('/resturant/food-status/{id}/{status}', [Menu::class, 'foodstatus'])->name('menu.foodstatus');
Route::post('/resturant/chef-status/{id}/{status}', [Menu::class, 'specialstatus'])->name('menu.specialstatus');
Route::post('/resturant/seller-status/{id}/{status}', [Menu::class, 'sellerstatus'])->name('menu.sellerstatus');


Route::get('/resturant/menu', [Menu::class, 'menuView'])->name('menu.view');
 

// category 
// create
Route::get('/resturant/create-category', [Category::class, 'CategoryAdd'])->name('menu.addcategory');
Route::post('/resturant/store', [Category::class, 'CategoryStore'])->name('menu.category.save');
// edit
Route::get('/resturant/update-category/{id}', [Category::class, 'categoryEdit'])->name('menu.category.edit');
Route::put('/resturant/edit-category/{id}', [Category::class, 'editcategory'])->name('menu.category.update');
// delete
Route::post('/resturant/category-delete/{id}', [Category::class, 'categorydestroy'])->name('menu.category.destroy');
Route::post('/resturant/category-status/{id}/{status}', [Category::class, 'categorystatus'])->name('menu.category.status');
Route::post('/resturant/sortabledatatable',[Category::class, 'updatesort']);

// view
Route::get('/resturant/category', [Category::class, 'CategoryView'])->name('menu.categoryview');



//subcategory
Route::get('/resturant/create-subcategory', [Subcategory::class, 'SubcategoryAdd'])->name('menu.addsubcategory');
Route::post('/resturant/store-subcategory', [Subcategory::class, 'SubCategoryStore'])->name('menu.subcategory.save');
// edit
Route::get('/resturant/update-subcategory/{id}', [Subcategory::class, 'subcategoryEdit'])->name('menu.subcategory.edit');
Route::put('/resturant/edit-subcategory/{id}', [Subcategory::class, 'subeditcategory'])->name('menu.subcategory.update');
// delete
Route::post('/resturant/subcategory-delete/{id}', [Subcategory::class, 'subcategorydestroy'])->name('menu.subcategory.destroy');
Route::post('/resturant/subcategory-status/{id}/{status}', [Subcategory::class, 'subcategorystatus'])->name('menu.subcategory.status');
// view
Route::get('/resturant/subcategory', [Subcategory::class, 'SubcategoryView'])->name('menu.subcategoryview');



// create employee
Route::get('/resturant/create-employee', [Employees::class, 'employeeAdd'])->name('menu.addemployee');
Route::post('/resturant/store-employee', [Employees::class, 'employeeStore'])->name('menu.employee.save');
// edit
Route::get('/resturant/update-employee/{id}', [Employees::class, 'employeeEdit'])->name('menu.employee.edit');
Route::put('/resturant/edit-employee/{id}', [Employees::class, 'editemployee'])->name('menu.employee.update');
// delete
Route::post('/resturant/employee-delete/{id}', [Employees::class, 'employeedestroy'])->name('menu.employee.destroy');
Route::post('/resturant/employee-status/{id}/{status}', [Employees::class, 'employeestatus'])->name('menu.employee.status');
// view
Route::get('/resturant/employee', [Employees::class, 'employeeView'])->name('menu.employeeview');

// table detail
Route::get('/resturant/create-table', [TableController::class, 'tableAdd'])->name('menu.addtable');
Route::post('/resturant/store-table', [TableController::class, 'tablestore'])->name('menu.table.save');
// edit
Route::get('/resturant/update-table/{id}', [TableController::class, 'tableEdit'])->name('menu.table.edit');
Route::put('/resturant/edit-table/{id}', [TableController::class, 'edittable'])->name('menu.table.update');
// delete
Route::post('/resturant/table-delete/{id}', [TableController::class, 'tabledestroy'])->name('menu.table.destroy');
Route::post('/resturant/table-status/{id}/{status}', [TableController::class, 'tablestatus'])->name('menu.table.status');
Route::post('/resturant/table-book/', [TableController::class, 'tableReservestatus'])->name('menu.tablebook.status');

// view
Route::get('/resturant/table-view', [TableController::class, 'index'])->name('menu.tableview');


Route::get('/resturant/table-seatView', [TableController::class, 'seatView'])->name('menu.tableseatview');
});

Route::get('/restra/{id}', [HomeController::class, 'index'])->name('menu.list')->where('id', '[0-9]+');
// Route::get('/restras/{id}', [HomeController::class, 'demo'])->name('menus.listd');
// Route::post('/restra/search/', [HomeController::class, 'filter'])->name('menus.list.search');
Route::post('/restra/filter/', [HomeController::class, 'filter'])->name('menus.list.filter');
// Route::post('/restra/advancesearch/', [HomeController::class, 'filter'])->name('menus.list1');
// Route::post('/restra/filter/food_type/', [HomeController::class, 'filter'])->name('menus.list2');




// Route::get('/resturant/order', [Subcategory::class, 'resturant_view_order'])->name('menu.vieworder');
// Route::get('/resturant/subcategory', [HomeController::class, 'resturant_view_subcat'])->name('menu.subcategoryview');