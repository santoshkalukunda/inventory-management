<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseDueController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDueController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//dealers Route
Route::get('dealers/search',[DealerController::class,'search'])->name('dealers.search');
Route::resource('dealers',DealerController::class);

//brand route
Route::get('brands/search',[BrandController::class,'search'])->name('brands.search');
Route::resource('brands',BrandController::class);

//category route
Route::get('categories/search',[CategoryController::class,'search'])->name('categories.search');
Route::resource('categories',CategoryController::class);

//product route
Route::get('products/search',[ProductController::class,'search'])->name('products.search');
Route::resource('products',ProductController::class);

//unit route
Route::get('units/search',[UnitController::class,'search'])->name('units.search');
Route::resource('units',UnitController::class);

//purches route
Route::get('purchase/{dealer}/create',[PurchaseController::class,'create'])->name('purchase.create');
Route::post('purchase/{dealer}/store',[PurchaseController::class,'store'])->name('purchase.store');
Route::get('purchase',[PurchaseController::class,'index'])->name('purchase.index');
Route::delete('purchase/{purchase}',[PurchaseController::class,'destroy'])->name('purchase.destroy');
Route::get('purchase/{purchase}/edit',[PurchaseController::class,'edit'])->name('purchase.edit');
Route::get('purchase/{purchase}/show',[PurchaseController::class,'show'])->name('purchase.show');
Route::put('purchase/{purchase}',[PurchaseController::class,'update'])->name('purchase.update');
Route::post('purchase/find',[PurchaseController::class,'find'])->name('purchase.find');
Route::get('purchase/search',[PurchaseController::class,'search'])->name('purchase.search');

Route::get('purchase/pdf',[PurchaseController::class,'pdf'])->name('purchase.pdf');
Route::get('purchase/excel',[PurchaseController::class,'exp'])->name('purchase.excel');

//customers route
Route::post('customers/find',[CustomerController::class,'find'])->name('customers.find');
Route::get('customers/search',[CustomerController::class,'search'])->name('customers.search');
Route::resource('customers',CustomerController::class);

//sales route
Route::get('bills',[BillController::class,'index'])->name('bills.index');
Route::get('bills/search',[BillController::class,'search'])->name('bills.search');
Route::get('bills/{customer}/create/{bill}',[BillController::class,'create'])->name('bills.create');
Route::put('bills/{bill}',[BillController::class,'update'])->name('bills.update');
Route::delete('bills/{bill}',[BillController::class,'destroy'])->name('bills.destroy');
Route::get('bills/{customer}',[BillController::class,'store'])->name('bills.store');
Route::post('bills/{bill}/cancel',[BillController::class,'cancel'])->name('bills.cancel');
Route::get('bills/{bill}/show',[BillController::class,'show'])->name('bills.show');



//sales route
Route::get('sales',[SaleController::class,'index'])->name('sales.index');
Route::get('sales/{customer}/create',[SaleController::class,'create'])->name('sales.create');
Route::post('sales/{customer}/store/{bill}',[SaleController::class,'store'])->name('sales.store');
Route::delete('sales/{sale}',[SaleController::class,'destroy'])->name('sales.destroy');
// Route::get('sales/{sale}',[SaleController::class,'edit'])->name('sales.edit');
Route::put('sales/{sale}',[SaleController::class,'update'])->name('sales.update');
Route::get('sales/search',[SaleController::class,'search'])->name('sales.search');


//store route
Route::get('stores',[StoreController::class,'index'])->name('stores.index');
Route::get('stores/search',[StoreController::class,'search'])->name('stores.search');


//saledeu
Route::get('sale-dues',[SaleDueController::class,'index'])->name('sale-dues.index');
Route::post('sale-dues/{customer}/create/{bill}',[SaleDueController::class,'store'])->name('sale-dues.store');
Route::delete('sale-dues/{saleDue}',[SaleDueController::class,'destroy'])->name('sale-dues.destroy');
Route::get('sale-dues/search',[SaleDueController::class,'search'])->name('sale-dues.search');

//parchase route
Route::get('purchase-dues',[PurchaseDueController::class,'index'])->name('purchase-dues.index');
Route::get('purchase-dues/search',[PurchaseDueController::class,'search'])->name('purchase-dues.search');
Route::post('purchase-dues/{purchase}/create',[PurchaseDueController::class,'store'])->name('purchase-dues.store');
Route::delete('purchase-dues/{purchaseDue}',[PurchaseDueController::class,'destroy'])->name('purchase-dues.destroy');