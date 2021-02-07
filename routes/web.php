<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UnitController;
use App\Models\Purchase;
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
Route::put('purchase/{purchase}',[PurchaseController::class,'update'])->name('purchase.update');
Route::post('purchase/find',[PurchaseController::class,'find'])->name('purchase.find');
Route::get('purchase/pdf',[PurchaseController::class,'pdf'])->name('purchase.pdf');
Route::get('purchase/excel',[PurchaseController::class,'exp'])->name('purchase.excel');
