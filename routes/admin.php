<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Vendor\ImageController;
use App\Http\Controllers\Admin\ProductClassController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\CustomerCashWithdrawRequestController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\VendorWarningsController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\VendorRateController;
use App\Http\Controllers\Admin\ProductRateController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductQuantityController;
use App\Http\Controllers\Admin\AboutUsContentController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DomesticZoneController;
use App\Http\Controllers\Admin\DomesticZoneDeliveryFeesController;
use App\Http\Controllers\Admin\TorodCompanyController;
use App\Http\Controllers\Admin\UsageAgreementContentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\VendorUserController;
use App\Http\Controllers\Admin\VendorWalletController;
use App\Http\Controllers\Admin\PrivacyPolicyContentController;
use App\Http\Controllers\Admin\VendorWarehouseRequestController;
use App\Http\Controllers\Admin\ShippingMethodController;

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

    //Auth routes for admin
    Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class,'login']);

    Route::post('logout', [LoginController::class,'logout'])->name('logout');

    Route::get('forget', [ForgotPasswordController::class,'showLinkRequestForm'])->name('forget');
    Route::post('forget', [ForgotPasswordController::class,'sendResetLinkEmail']);

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password_reset_get');
    Route::post('reset-password', [ResetPasswordController::class, 'submitResetPasswordForm'])->name('password_reset_post');

    Route::middleware(['admin.auth', 'admin.can'])->group(function () {
        /* Home dashboard routes */
        Route::get('home', [AdminController::class,'index'])->name('home');
        Route::get('/', [AdminController::class,'index']);


        /* Notifications routes */
        //Route::get('/send-notification',[AdminController::class,'notification'])->name('notification');
        Route::patch('/notifications/fcm-token', [AdminController::class, 'updateToken'])->name('notifications.fcmToken');
        Route::post('/notifications/mark-as-read',[AdminController::class,'markNotification'])->name('notifications.mark-as-read');

        /* Vendor routes */
        // Breadcrumb done
        Route::get('vendors', [VendorController::class,'index'])->name('vendors.index');
        Route::get('vendors/show/{vendor:id}', [VendorController::class,'show'])->name('vendors.show');
        Route::get('vendors/edit/{vendor:id}', [VendorController::class,'edit'])->name('vendors.edit');
        Route::post('vendors/update/{vendor:id}', [VendorController::class,'update'])->name('vendors.update');
        Route::post('vendors/approve/{vendor:id}', [VendorController::class,'approve'])->name('vendors.approve');
        Route::post('vendors/activation/{vendor:id}', [VendorController::class,'changeStatus'])->name('vendors.change-status');
        Route::post('vendors/accept-set-ratio', [VendorController::class, 'accept_set_ratio'])->name('vendors.accept-set-ratio'); //ajax
        //Route::get('vendor/delete/{vendor:id}', [VendorController::class,'destroy'])->name('vendorsDelete');

        /* Customers routes */
        // Breadcrumb done
        Route::get('customers', [CustomerController::class,'index'])->name('customers.index');
        Route::get('customers/show/{user:id}', [CustomerController::class,'show'])->name('customers.show');
        Route::post('customers/priority/{user:id}', [CustomerController::class,'changePriority'])->name('customers.change-priority');
        Route::post('customers/block/{user:id}', [CustomerController::class,'block'])->name('customers.block');
        Route::get('customers/edit/{user:id}', [CustomerController::class,'edit'])->name('customers.edit');
        Route::post('customers/update/{user:id}', [CustomerController::class,'update'])->name('customers.update');

        /* Vendor Warnings routes */
        // Breadcrumb done
        Route::get('vendors/warnings/{vendor:id}', [VendorWarningsController::class,'index'])->name('vendors.warnings.index');
        Route::post('vendors/warnings/store/', [VendorWarningsController::class,'store'])->name('vendors.warnings.store');

        /* transactions routes */
        // Breadcrumb done
        Route::get('transactions', [TransactionController::class,'index'])->name('transactions.index');
        Route::get('transactions/show/{transaction:id}', [TransactionController::class,'show'])->name('transactions.show');
        Route::get('transactions/invoice/{transaction:id}', [TransactionController::class,'invoice'])->name('transactions.invoice');
        Route::get('transactions/invoice-pdf/{transaction:id}', [TransactionController::class,'invoicePdf'])->name('transactions.pdf-invoice');
        Route::get('transactions/manage/{transaction:id}', [TransactionController::class,'manage'])->name('transactions.manage');
        Route::post('transactions/update/{transaction:id}', [TransactionController::class,'update'])->name('transactions.update');

        /* carts routes */
        // Breadcrumb done
        Route::get('carts', [CartController::class,'index'])->name('carts.index');
        Route::get('carts/show/{cart:id}', [CartController::class,'show'])->name('carts.show');
        Route::get('carts/delete/{cart:id}', [CartController::class,'destroy'])->name('carts.delete');

        /* Manage Customers Wallets */
        // Breadcrumb done
        Route::get('wallets/{id}/manage-wallet-balance', [WalletController::class,'manageWalleBalance'])->name('wallets.manageWalleBalance');
        Route::post('wallets/{id}/manage-wallet-balance', [WalletController::class,'increaseAndDecreaseAmount'])->name('wallets.increaseAndDecreaseAmount');
        Route::resource('wallets', WalletController::class);

        /* Manage Categories */
        Route::group([
                "prefix" => "categories",
                "as" => "categories."
        ], function () {
            Route::get("", [CategoryController::class, "index"])->name("index");
            Route::get("create", [CategoryController::class, "create"])->name("create");
            Route::get("{parent_id}/create-sub-category", [CategoryController::class, "createSubCategory"])->name("createSubCategory");
            Route::get("{parent_id}/create-sub-child-category", [CategoryController::class, "createSubChildCategory"])->name("createSubChildCategory");
            Route::post("", [CategoryController::class, "store"])->name("store");
            Route::post("updateCategoryOrder", [CategoryController::class, "updateCategoryOrder"])->name("updateCategoryOrder");
            Route::get("show/{id}", [CategoryController::class, "show"])->name("show");
            Route::get("show-sub-category/{id}", [CategoryController::class, "showSubCategory"])->name("showSubCategory");
            Route::get("show-sub-child-category/{id}", [CategoryController::class, "showSubChildCategory"])->name("showSubChildCategory");
            Route::get("{id}/edit", [CategoryController::class, "edit"])->name("edit");
            Route::get("edit-sub/{id}", [CategoryController::class, "editSubCategory"])->name("editSubCategory");
            Route::get("edit-child/{id}", [CategoryController::class, "editSubChildCategory"])->name("editSubChildCategory");
            Route::put("{id}", [CategoryController::class, "update"])->name("update");
            Route::delete("{id}", [CategoryController::class, "destroy"])->name("destroy");       
        });


        /* Manage Product Classes */
        // Breadcrumb done
        Route::resource('productClasses', ProductClassController::class);
        ///////////////////////////////////// Product Actions //////////////////////////////////////////
        // Breadcrumb done
        Route::resource('products', ProductController::class);
        Route::get('products/print-barcode/{product}', [ProductController::class, 'printBarcode'])->name('products.print-barcode');
        Route::post('products/approve/{product:id}', [ProductController::class,'approve'])->name('products.approve');
        Route::get('/get-category-by-parent-id',[ProductController::class,'getSubCategories'])->name('products.get_sub_categories');
        Route::post('/upload-image',[ImageController::class,'upload_product_images'])->name('admin.upload_product_images');
        Route::put('/toggle-status/{product}',[ProductController::class, 'acceptProduct'])->name('products.toggle-status');
        Route::put('/accept-update/{product}',[ProductController::class, 'acceptUpdate'])->name('products.accept-update');
        Route::put('/refuse-update/{product}',[ProductController::class, 'refuseUpdate'])->name('products.refuse-update');

        /* Manage Countries */
        // Breadcrumb done
        Route::resource('countries', CountryController::class);

        /** Coupons */
        // Breadcrumb done
        Route::resource('coupons', CouponController::class);
        Route::post('coupons/status/{coupon:id}', [CouponController::class,'changeStatus'])->name('coupons.change-status');
        Route::get('coupons/products/{query}', [CouponController::class,'product'])->name('coupons.products');

        /* Manage Cities */
        // Breadcrumb done
        Route::resource('cities', CityController::class);

        /* Manage Areas */
        // Breadcrumb done
        Route::resource('areas', AreaController::class);

        /* certificate routes */
        // Breadcrumb done
        Route::get('certificates', [CertificateController::class,'index'])->name('certificates.index');
        Route::get('certificates/add/', [CertificateController::class,'add'])->name('certificates.create');
        Route::post('certificates/store/', [CertificateController::class,'store'])->name('certificates.store');
        Route::get('certificates/edit/{certificate:id}', [CertificateController::class,'edit'])->name('certificates.edit');
        Route::post('certificates/update/{certificate:id}', [CertificateController::class,'update'])->name('certificates.update');
        Route::get('certificates/delete/{certificate:id}', [CertificateController::class,'destroy'])->name('certificates.delete');
        Route::get('certificates/requests/{certificate:id}', [CertificateController::class,'requests'])->name('certificates.requests');
        Route::post('certificates/approve/{certificate_request:id}', [CertificateController::class,'approve'])->name('certificates.approve');
        Route::post('certificates/reject/{certificate_request:id}', [CertificateController::class,'reject'])->name('certificates.reject');

        /* vendor roles (permission) routes */
        // Breadcrumb done
        Route::get('roles', [RoleController::class,'index'])->name('roles.index');
        Route::get('roles/add/', [RoleController::class,'create'])->name('roles.create');
        Route::post('roles/store/', [RoleController::class,'store'])->name('roles.store');
        Route::get('roles/edit/{role:id}', [RoleController::class,'edit'])->name('roles.edit');
        Route::post('roles/update/{role:id}', [RoleController::class,'update'])->name('roles.update');
        Route::get('roles/delete/{role:id}', [RoleController::class,'destroy'])->name('roles.delete');

        /* vendor users routes */
        // Breadcrumb done
        Route::get('vendor-users', [VendorUserController::class,'index'])->name('vendor-users.index');
        Route::get('vendor-users/add/', [VendorUserController::class,'add'])->name('vendor-users.create');
        Route::post('vendor-users/store/', [VendorUserController::class,'store'])->name('vendor-users.store');
        Route::get('vendor-users/edit/{user:id}', [VendorUserController::class,'edit'])->name('vendor-users.edit');
        Route::patch('vendor-users/update/{user:id}', [VendorUserController::class,'update'])->name('vendor-users.update');
        Route::post('vendor-users/roles/{id}', [VendorUserController::class,'getVendorRoles'])->name('vendor-users.roles');
        Route::get('vendor-users/delete/{user:id}', [VendorUserController::class,'destroy'])->name('vendor-users.delete');
        Route::post('vendor-users/block/{user:id}', [VendorUserController::class,'block'])->name('vendor-users.block');


        /* Manage Static Content */
        // Breadcrumb done
        Route::resource('about-us', AboutUsContentController::class);
        // Breadcrumb done
        Route::resource('privacy-policy', PrivacyPolicyContentController::class);
        // Breadcrumb done
        Route::resource('usage-agreement', UsageAgreementContentController::class);
        // Breadcrumb done
        Route::resource('qna', QnaController::class);
        // Breadcrumb done
        Route::resource('recipe', RecipeController::class);
        // Breadcrumb done
        Route::resource('blog', BlogController::class);

        Route::get('customer-cash-withdraw', [CustomerCashWithdrawRequestController::class, 'index'])
            ->name('customer-cash-withdraw.index');
        // Breadcrumb done
        Route::get('customer-cash-withdraw/{id}', [CustomerCashWithdrawRequestController::class, 'show'])
            ->name('customer-cash-withdraw.show');
        Route::put('customer-cash-withdraw/{withdrawRequest}', [CustomerCashWithdrawRequestController::class, 'update'])
            ->name('customer-cash-withdraw.update');
        // Breadcrumb done
        Route::resource('productRates', ProductRateController::class);
        // Breadcrumb done
        Route::resource('product-quantities', ProductQuantityController::class);
        // Breadcrumb done
        Route::resource('vendorRates', VendorRateController::class);
        
        // Breadcrumb done
        Route::resource('wareHouseRequests', VendorWarehouseRequestController::class);
        Route::get('wareHouseRequests/product/{id}','VendorWarehouseRequestController@showProducts')->name('wareHouseRequests.show-products');
        Route::get('wareHouseRequests/create/{id}', [VendorWarehouseRequestController::class, 'createForVendor'])->name("vendor-warehouse-request");

        // Breadcrumb done
        Route::resource('slider', SliderController::class);
        
        Route::post('slider/image/{id}', [SliderController::class, 'deleteImage'])->name('slider.delete-image');
        // Breadcrumb done
        Route::resource('subAdmins', SubAdminController::class);
        
        // Breadcrumb done
        Route::resource('rules', RuleController::class);
        
        // Breadcrumb done
        Route::resource('vendorWallets', VendorWalletController::class);
        
        // Breadcrumb done
        Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update-all');
        Route::resource('settings', SettingController::class)->only(['index', 'edit', 'update']);
        
        // Breadcrumb done
        Route::resource('warehouses', WarehouseController::class);
        
        // Breadcrumb done
        Route::resource('domestic-zones', DomesticZoneController::class);
        Route::get('domestic-zones-delivery-fees/download-demo', [DomesticZoneDeliveryFeesController::class, 'downloadDeliveryFeesDemo'])
            ->name('domestic-zones-delivery-fees.download-demo');
        Route::post('domestic-zones-delivery-fees/{domestic}/upload-sheet', [DomesticZoneDeliveryFeesController::class, 'uploadSheet'])
            ->name('domestic-zones-delivery-fees.upload-sheet');

        // Breadcrumb done
        Route::resource('torodCompanies', TorodCompanyController::class);

        // Breadcrumb done
        Route::resource('banks', BankController::class);
        // Shipping Method done
        Route::resource('shipping-methods', ShippingMethodController::class);
        Route::post('shipping-methods/{shippingMethod}/sync-zones', [ShippingMethodController::class, 'syncZones'])->name('shipping-methods.sync-zones');
    });
