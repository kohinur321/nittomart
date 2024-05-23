<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use \App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
   // return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);
Route::get('/product/details/{slug}',[HomeController::class, 'productDetails']);
Route::get('/product/view-cart', [HomeController::class, 'viewCart']);
Route::get('/product/checkout', [HomeController::class, 'productCheckout']);
Route::get('/shop-products', [HomeController::class, 'shopProduct']);
Route::get('/return-products', [HomeController::class, 'returnProduct']);
Route::get('/privecy-policy', [HomeController::class, 'privecy']);

// Add to cart Routes....
Route::post('/product/addtocart-details/{id}', [HomeController::class, 'addtoCartDetails']);
Route::get('/product/addtocart/{id}', [HomeController::class, 'addtoCart']);
Route::get('/product/addtocart/delete/{id}', [HomeController::class, 'deleteAddtoCart']);

//Make Order..
Route::post('/confirm-order', [HomeController::class, 'confirmOrder']);
Route::get('/order-confirmed/{invoiceId}', [HomeController::class, 'thankyouMessage']);

Auth::routes();

Route::get('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/login-access', [AdminController::class, 'loginCheck']);

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

//Category Routes
Route::get('/admin/category/list',[CategoryController::class, 'showCategory']);
Route::get('/admin/category/create',[CategoryController::class, 'createCategory']);
Route::post('/admin/category/store',[CategoryController::class, 'storeCategory']);
Route::get('/admin/category/delete/{id}',[CategoryController::class, 'deleteCategory']);
Route::get('/admin/category/edit/{id}',[CategoryController::class, 'editCategory']);
Route::post('/admin/category/update/{id}',[CategoryController::class, 'updateCategory']);


//SubCategory Routes
Route::get('/admin/sub-category/list',[SubCategoryController::class, 'showSubCategory']);
Route::get('/admin/sub-category/create',[SubCategoryController::class, 'createSubCategory']);
Route::post('/admin/sub-category/store',[SubCategoryController::class, 'storeSubCategory']);
Route::get('/admin/sub-category/delete/{id}',[SubCategoryController::class, 'deleteSubCategory']);
Route::get('/admin/sub-category/edit/{id}',[SubCategoryController::class, 'editSubCategory']);
Route::post('/admin/sub-category/update/{id}',[SubCategoryController::class, 'updateSubCategory']);


//Product Routes
Route::get('/admin/product/list',[ProductController::class, 'showProduct']);
Route::get('/admin/product/create',[ProductController::class, 'createProduct']);
Route::post('/admin/product/store',[ProductController::class, 'storeProduct']);
Route::get('/admin/product/delete/{id}',[ProductController::class, 'deleteProduct']);
Route::get('/admin/product/edit/{id}',[ProductController::class, 'editProduct']);
Route::post('/admin/product/update/{id}',[ProductController::class, 'updateProduct']);


//Orders Routes
Route::get('/admin/orders/edit/{id}',[OrderController::class, 'editOrders']);
Route::post('/admin/orders/update/{id}',[OrderController::class, 'updateOrders']);
Route::get('/admin/orders/all-orders',[OrderController::class, 'showAllOrders']);
Route::get('/admin/orders/pending-orders',[OrderController::class, 'showPendingOrders']);
Route::get('/admin/orders/confirmed-orders',[OrderController::class, 'showConfirmedOrders']);
Route::get('/admin/orders/delivered-orders',[OrderController::class, 'showDeliveredOrders']);
Route::get('/admin/orders/cancelled-orders',[OrderController::class, 'showCancelledOrders']);
Route::get('/admin/order/status-pending/{id}',[OrderController::class, 'statusPending']);
Route::get('/admin/order/status-confirmed/{id}',[OrderController::class, 'statusConfirmed']);
Route::get('/admin/order/status-delivered/{id}',[OrderController::class, 'statusDelivered']);
Route::get('/admin/order/status-cancelled/{id}',[OrderController::class, 'statusCancelled']);

//Settings...
Route::get('/admin/general-setting', [SettingController::class, 'showSettings']);
Route::post('/admin/general-setting/update', [SettingController::class, 'updateSettings']);
