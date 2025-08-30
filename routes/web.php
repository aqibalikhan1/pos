<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTransactionController;
use App\Http\Controllers\CreditSaleController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\CreditNoteReceivedController;

use App\Http\Controllers\PosTerminalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

// Welcome route (optional)
Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('main-dashboard');
    })->name('dashboard');

    // POS Routes
    Route::prefix('pos')->group(function () {
        Route::get('/', function () {
            return view('pos.dashboard');
        })->name('pos.dashboard');
        
        // POS Terminal
        Route::get('terminal', [PosTerminalController::class, 'index'])->name('pos.terminal');
        Route::post('terminal/search-products', [PosTerminalController::class, 'searchProducts'])->name('pos.terminal.search-products');
        Route::post('terminal/process-sale', [PosTerminalController::class, 'processSale'])->name('pos.terminal.process-sale');
        Route::post('terminal/quick-create-customer', [PosTerminalController::class, 'quickCreateCustomer'])->name('pos.terminal.quick-create-customer');
        Route::get('terminal/products-by-category/{categoryId}', [PosTerminalController::class, 'getProductsByCategory'])->name('pos.terminal.products-by-category');
        Route::get('terminal/currency-symbol', [PosTerminalController::class, 'getCurrencySymbol'])->name('pos.terminal.currency-symbol');
        
        // Product Management
        Route::resource('products', ProductController::class);
        Route::get('products/data', [ProductController::class, 'getProducts'])->name('products.data');
        Route::get('products/import', [ProductController::class, 'importForm'])->name('products.import.form');
        Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
        
        // Sale Invoice Management
        Route::resource('sale-invoices', SaleInvoiceController::class);
        Route::get('sale-invoices/{saleInvoice}/print', [SaleInvoiceController::class, 'print'])->name('sale-invoices.print');
        Route::get('sale-invoices/products/data', [SaleInvoiceController::class, 'getProducts'])->name('sale-invoices.products.data');
        Route::get('sale-invoices/customers/data', [SaleInvoiceController::class, 'getCustomers'])->name('sale-invoices.customers.data');
        Route::get('sale-invoices/employees/data', [SaleInvoiceController::class, 'getEmployees'])->name('sale-invoices.employees.data');
    });
    
    Route::resource('categories', CategoryController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('towns', TownController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('routes', \App\Http\Controllers\RouteController::class);
    
    // Settings Menu with Tax Submenu
    Route::prefix('settings')->name('settings.')->group(function () {
        // Tax Management under Settings submenu
        Route::resource('tax-types', \App\Http\Controllers\TaxTypeController::class);
        Route::resource('tax-rates', \App\Http\Controllers\TaxRateController::class);
        
        // Additional tax-related routes
        Route::get('tax-configuration', function () {
            return view('pos.settings.tax-configuration');
        })->name('tax-configuration');
        
        // Currency Settings Management
        Route::resource('currency-settings', \App\Http\Controllers\CurrencySettingController::class);
    });
    
    // Route-specific routes
    Route::prefix('routes')->group(function () {
        Route::get('{route}/assign-customers', [\App\Http\Controllers\RouteController::class, 'assignCustomers'])->name('routes.assign-customers');
        Route::post('{route}/assign-customers', [\App\Http\Controllers\RouteController::class, 'storeCustomerAssignments'])->name('routes.store-customers');
        Route::delete('{route}/customers/{customer}', [\App\Http\Controllers\RouteController::class, 'removeCustomer'])->name('routes.remove-customer');
        Route::get('data', [\App\Http\Controllers\RouteController::class, 'getRoutes'])->name('routes.data');
    });

    // Purchase Management
    Route::prefix('purchases')->group(function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('/create', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('/', [PurchaseController::class, 'store'])->name('purchases.store');
        Route::get('/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
        Route::get('/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
        Route::put('/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
        Route::delete('/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
        Route::post('/{purchase}/receive', [PurchaseController::class, 'receive'])->name('purchases.receive');
        Route::get('/products/search', [PurchaseController::class, 'searchProducts'])->name('purchases.products.search');
    });

    Route::prefix('expenses')->name('expenses.')->group(function () {
        // Extra page (summary)
        Route::get('summary', [ExpenseController::class, 'summary'])->name('summary');
        Route::get('/category/{category}', [ExpenseController::class, 'byCategory'])->name('by-category');

        // Resource controller (main CRUD)
        Route::resource('/', ExpenseController::class)->parameters(['' => 'expense'])->names([
                'index'   => 'index',
                'create'  => 'create',
                'store'   => 'store',
                'show'    => 'show',
                'edit'    => 'edit',
                'update'  => 'update',
                'destroy' => 'destroy',
            ]);
    });
    
    // Account Management
    Route::prefix('accounts')->name('accounts.')->group(function () {
        // Submodules first
        Route::resource('supplier-payments', SupplierPaymentController::class);
        Route::resource('credit-sales', CreditSaleController::class);
        Route::resource('transactions', AccountTransactionController::class);

        // Main Accounts resource
        Route::resource('/', AccountController::class)->parameters(['' => 'account'])->names([
            'index'   => 'index',
            'create'  => 'create',
            'store'   => 'store',
            'show'    => 'show',
            'edit'    => 'edit',
            'update'  => 'update',
            'destroy' => 'destroy',
        ]);
    });

    // Credit Notes Management
    Route::resource('credit-notes', CreditNoteReceivedController::class)->parameters(['credit-notes' => 'creditNote'])->names([
        'index'   => 'credit-notes.index',
        'create'  => 'credit-notes.create',
        'store'   => 'credit-notes.store',
        'show'    => 'credit-notes.show',
        'edit'    => 'credit-notes.edit',
        'update'  => 'credit-notes.update',
        'destroy' => 'credit-notes.destroy',
    ]);
});
