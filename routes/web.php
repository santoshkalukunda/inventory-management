<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseBillController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseDueController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDueController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
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
    return redirect()->route('login');
});

Auth::routes();

//admin role
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //dealers Route
    Route::get('dealers/search', [DealerController::class, 'search'])->name('dealers.search');
    Route::resource('dealers', DealerController::class);

    //brand route
    Route::get('brands/search', [BrandController::class, 'search'])->name('brands.search');
    Route::resource('brands', BrandController::class);

    //category route
    Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::resource('categories', CategoryController::class);

    //product route
    Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
    Route::resource('products', ProductController::class);

    //unit route
    Route::get('units/search', [UnitController::class, 'search'])->name('units.search');
    Route::resource('units', UnitController::class);

    //purches route
    Route::get('purchases/{dealer}/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('purchases/{purchaseBill}/store', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('purchases', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::delete('purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
    // Route::get('purchase/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::get('purchases/{dealer}/show', [PurchaseController::class, 'show'])->name('purchase.show');
    // Route::put('purchase/{purchase}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::post('purchases/find', [PurchaseController::class, 'find'])->name('purchase.find');
    Route::get('purchases/search', [PurchaseController::class, 'search'])->name('purchase.search');

    //PDF
    Route::get('purchase/pdf', [PurchaseController::class, 'pdf'])->name('purchase.pdf');
    Route::get('bills/{bill}/pdf', [BillController::class, 'pdf'])->name('bills.pdf');
    Route::get('purchase/excel', [PurchaseController::class, 'exp'])->name('purchase.excel');

    //customers route
    Route::post('customers/find', [CustomerController::class, 'find'])->name('customers.find');
    Route::get('customers/search', [CustomerController::class, 'search'])->name('customers.search');
    Route::resource('customers', CustomerController::class);

    //bill route
    Route::get('bills', [BillController::class, 'index'])->name('bills.index');
    Route::get('bills/search', [BillController::class, 'search'])->name('bills.search');
    Route::get('bills/create/{bill}', [BillController::class, 'create'])->name('bills.create');
    Route::put('bills/{bill}', [BillController::class, 'update'])->name('bills.update');
    Route::delete('bills/{bill}', [BillController::class, 'destroy'])->name('bills.destroy');
    Route::get('bills/{customer}', [BillController::class, 'store'])->name('bills.store');
    Route::post('bills/{bill}/cancel', [BillController::class, 'cancel'])->name('bills.cancel');
    Route::get('bills/{bill}/show', [BillController::class, 'show'])->name('bills.show');

    //sales route
    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales/store/{bill}', [SaleController::class, 'store'])->name('sales.store');
    Route::delete('sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
    // Route::get('sales/{sale}',[SaleController::class,'edit'])->name('sales.edit');
    Route::put('sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
    Route::get('sales/search', [SaleController::class, 'search'])->name('sales.search');


    //store route
    Route::get('stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('stores/search', [StoreController::class, 'search'])->name('stores.search');

    //saledeu
    Route::get('sale-dues', [SaleDueController::class, 'index'])->name('sale-dues.index');
    Route::post('sale-dues/create/{bill}', [SaleDueController::class, 'store'])->name('sale-dues.store');
    Route::delete('sale-dues/{saleDue}', [SaleDueController::class, 'destroy'])->name('sale-dues.destroy');
    Route::get('sale-dues/search', [SaleDueController::class, 'search'])->name('sale-dues.search');

    //parchase route
    Route::get('purchase-dues', [PurchaseDueController::class, 'index'])->name('purchase-dues.index');
    Route::get('purchase-dues/search', [PurchaseDueController::class, 'search'])->name('purchase-dues.search');
    Route::post('purchase-dues/{purchaseBill}/create', [PurchaseDueController::class, 'store'])->name('purchase-dues.store');
    Route::delete('purchase-dues/{purchaseDue}', [PurchaseDueController::class, 'destroy'])->name('purchase-dues.destroy');

    //company profile
    Route::get('companies', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::post('companies', [CompanyController::class, 'store'])->name('companies.store');

    //user route
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/search', [UserController::class, 'search'])->name('users.search');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('users/{user}/change-password', [UserController::class, 'changePasswordShow'])->name('users.changePasswordShow');
    Route::post('users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');

    //log route
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    //route purchaceBill
    Route::get('purchase-bills/search', [PurchaseBillController::class, 'search'])->name('purchase-bills.search');
    Route::get('purchase-bills/{dealer}', [PurchaseBillController::class, 'store'])->name('purchase-bills.store');
    Route::get('purchase-bills/create/{purchaseBill}', [PurchaseBillController::class, 'create'])->name('purchase-bills.create');
    Route::put('purchase-bills/{purchaseBill}', [PurchaseBillController::class, 'update'])->name('purchase-bills.update');
    Route::get('purchase-bills', [PurchaseBillController::class, 'index'])->name('purchase-bills.index');
    Route::delete('purchase-bills/{purchaseBill}', [PurchaseBillController::class, 'destroy'])->name('purchase-bills.destroy');
    Route::get('purchase-bills/{purchaseBill}/show', [PurchaseBillController::class, 'show'])->name('purchase-bills.show');
});

//user role
Route::group(['middleware' => ['role:user|admin']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //route dealers
    Route::get('dealers/search', [DealerController::class, 'search'])->name('dealers.search');
    Route::get('dealers', [DealerController::class, 'index'])->name('dealers.index');
    Route::get('dealers/create', [DealerController::class, 'create'])->name('dealers.create');
    Route::post('dealers', [DealerController::class, 'store'])->name('dealers.store');
    Route::get('dealers/{dealer}/edit', [DealerController::class, 'edit'])->name('dealers.edit');
    Route::put('dealers/{dealer}/update', [DealerController::class, 'update'])->name('dealers.update');
    Route::get('dealers/{dealer}', [DealerController::class, 'show'])->name('dealers.show');


    //brand route
    Route::get('brands/search', [BrandController::class, 'search'])->name('brands.search');
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
    Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('brands/{brand}/update', [BrandController::class, 'update'])->name('brands.update');

    //category route
    Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');

    //unit route
    Route::get('units/search', [UnitController::class, 'search'])->name('units.search');
    Route::get('units', [UnitController::class, 'index'])->name('units.index');
    Route::post('units', [UnitController::class, 'store'])->name('units.store');
    Route::get('units/{user}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('units/{user}/update', [UnitController::class, 'update'])->name('units.update');

    //product route
    Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}/update', [ProductController::class, 'update'])->name('products.update');

    //purches route
    Route::get('purchases/{dealer}/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('purchases/{purchaseBill}/store', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('purchases', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('purchases/{dealer}/show', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('purchases/find', [PurchaseController::class, 'find'])->name('purchase.find');
    Route::get('purchases/search', [PurchaseController::class, 'search'])->name('purchase.search');

    //customers route
    Route::post('customers/find', [CustomerController::class, 'find'])->name('customers.find');
    Route::get('customers/search', [CustomerController::class, 'search'])->name('customers.search');
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('customers/{customer}/update', [CustomerController::class, 'update'])->name('customers.update');

    //bill pdf
    Route::get('bills/{bill}/pdf', [BillController::class, 'pdf'])->name('bills.pdf');
    //bill route
    Route::get('bills', [BillController::class, 'index'])->name('bills.index');
    Route::get('bills/search', [BillController::class, 'search'])->name('bills.search');
    Route::get('bills/create/{bill}', [BillController::class, 'create'])->name('bills.create');
    Route::put('bills/{bill}', [BillController::class, 'update'])->name('bills.update');
    Route::delete('bills/{bill}', [BillController::class, 'destroy'])->name('bills.destroy');
    Route::get('bills/{customer}', [BillController::class, 'store'])->name('bills.store');
    Route::get('bills/{bill}/show', [BillController::class, 'show'])->name('bills.show');


    //sales route
    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales/store/{bill}', [SaleController::class, 'store'])->name('sales.store');
    Route::delete('sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
    Route::get('sales/search', [SaleController::class, 'search'])->name('sales.search');


    //store route
    Route::get('stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('stores/search', [StoreController::class, 'search'])->name('stores.search');

    //saledeu
    Route::get('sale-dues', [SaleDueController::class, 'index'])->name('sale-dues.index');
    Route::post('sale-dues/create/{bill}', [SaleDueController::class, 'store'])->name('sale-dues.store');
    Route::get('sale-dues/search', [SaleDueController::class, 'search'])->name('sale-dues.search');

    //parchase route
    Route::get('purchase-dues', [PurchaseDueController::class, 'index'])->name('purchase-dues.index');
    Route::get('purchase-dues/search', [PurchaseDueController::class, 'search'])->name('purchase-dues.search');
    Route::post('purchase-dues/{purchaseBill}/create', [PurchaseDueController::class, 'store'])->name('purchase-dues.store');

    //user route
    Route::get('users/{user}/change-password', [UserController::class, 'changePasswordShow'])->name('users.changePasswordShow');
    Route::post('users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');

    //route purchaceBill
    Route::get('purchase-bills/search', [PurchaseBillController::class, 'search'])->name('purchase-bills.search');
    Route::get('purchase-bills/{dealer}', [PurchaseBillController::class, 'store'])->name('purchase-bills.store');
    Route::get('purchase-bills/create/{purchaseBill}', [PurchaseBillController::class, 'create'])->name('purchase-bills.create');
    Route::put('purchase-bills/{purchaseBill}', [PurchaseBillController::class, 'update'])->name('purchase-bills.update');
    Route::get('purchase-bills', [PurchaseBillController::class, 'index'])->name('purchase-bills.index');
    Route::get('purchase-bills/{purchaseBill}/show', [PurchaseBillController::class, 'show'])->name('purchase-bills.show');
});
