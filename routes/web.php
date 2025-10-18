<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\FarmCropController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\RegisterLoginCheckController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Public Home Routes
|--------------------------------------------------------------------------
*/
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/services', 'services')->name('services');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/news_info', 'news_info')->name('news_info');

    // Crops
    Route::get('/categories/{crop_type}', 'Categories')->name('categories');
    Route::get('/sessions/categories/{crop_type}/{crop_session}', 'Session_Categories')->name('Session_Categories');
    Route::get('/crop_details/{id}', 'crop_details')->name('crop_details');

    // Search
    Route::get('/search', 'search')->name('search');
    Route::get('/search-autocomplete', 'searchAutocomplete')->name('search.autocomplete');
    // Contact form
    Route::post('/contact/submit', 'contactSubmit')->name('contact.submit');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [RegisterLoginCheckController::class, 'login'])->name('login');
Route::post('/login_check', [RegisterLoginCheckController::class, 'login_check'])->name('login_check');

Route::post('/logout', function (Request $request) {
    $request->session()->flush();
    return redirect('/login');
})->name('logout');

// Register / Signup
Route::get('/signup', [RegisterLoginCheckController::class, 'signup'])->name('signup');
Route::post('/registerSave', [RegisterLoginCheckController::class, 'registerSave'])->name('registerSave');

// Password Reset
Route::post('/pw_change_link', [RegisterLoginCheckController::class, 'pw_change_link'])->name('pw_change_link');
Route::get('/pw_change/{role}/{email}', [RegisterLoginCheckController::class, 'pw_change'])->name('pw_change');
Route::post('/pass_change_save/{role}/{email}', [RegisterLoginCheckController::class, 'pass_change_save'])->name('pass_change_save');

/*
|--------------------------------------------------------------------------
| Admin Login & Signup
|--------------------------------------------------------------------------
*/
Route::controller(AdminLoginController::class)->group(function () {
    Route::get('/admin/login', 'a_login')->name('admin.login.page');
    Route::post('admin/login/check', 'admin_login_check')->name('admin_login_check');
    Route::post('/admin_pw_change_link', 'admin_pw_change_link')->name('admin_pw_change_link');
    Route::get('/admin_pw_change/{email}', 'admin_pw_change')->name('admin_pw_change');
    Route::post('/admin_pass_change_save/{email}', 'admin_pass_change_save')->name('admin_pass_change_save');

    // Route::middleware('a_check')->group(function () {
    Route::get('/admin/signup', 'admin_signup')->name('admin_signup');
    Route::post('admin/signup/save', 'admin_registerSave')->name('admin_registerSave');
    Route::get('/account_verify/{username}', 'admin_account_verify')->name('admin_account_verify');
    Route::post('/admin/registerUpdate', 'adminregisterUpdate')->name('adminregisterUpdate');
    //});
    Route::post('/admin/logout', function (Request $request) {
        $request->session()->flush();
        return redirect('/admin/login');
    })->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| Admin Home & Management
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->controller(AdminController::class)->group(function () {
    Route::get('/home', 'a_home')->name('a_home');
    // Crops
    Route::get('/published/crop', 'published_crops')->name('published_crops');
    Route::get('/crop/unpublished/{id}', 'crop_unpublished_save')->name('crop_unpublished_save');
    Route::get('/unpublished/crop', 'unpublished_crops')->name('unpublished_crops');
    Route::get('/crop/published/{id}', 'crop_published_save')->name('crop_published_save');
    Route::get('/deleted/crop', 'deleted_crops')->name('deleted_crops');
    Route::get('/crop/deleted/{id}', 'crop_delete')->name('crop_delete');

    // Categories
    Route::get('/add/Categories', 'add_categories')->name('add_categories');
    Route::post('/categories/save', 'save_categories_db')->name('save_categories_db');
    Route::get('/manage/categories', 'manage_categories')->name('manage_categories');
    Route::get('/change/categories/status/{id}', 'categories_status')->name('categories_status');
    Route::get('/edit/categories/{id}', 'edit_categories')->name('edit_categories');
    Route::post('/categories/update', 'update_categories_db')->name('update_categories_db');
    Route::get('/categories/delete/{id}', 'categories_delete')->name('categories_delete');

    // News
    Route::get('/add/news', 'add_news')->name('add_news');
    Route::post('/news/save', 'save_news_db')->name('save_news_db');
    Route::get('/manage/news', 'manage_news')->name('manage_news');
    Route::get('/edit/news/{id}', 'edit_news')->name('edit_news');
    Route::post('/news/update', 'update_news_db')->name('update_news_db');
    Route::get('/delete/news/{id}', 'delete_news')->name('delete_news');

    // Admin Profile & Settings
    Route::get('/profile', 'a_profile')->name('a_profile');
    Route::get('/settings', 'a_settings')->name('a_settings');

    // Users
    Route::get('/farmers', 'all_farmer')->name('all_farmer');
    Route::get('/customers', 'all_customer')->name('all_customer');
    Route::get('/farmer/{id}', 'f_action')->name('f_action');
    Route::get('/customer/{id}', 'c_action')->name('c_action');
    Route::get('farmerr/profile/{id}', 'farmer_profile')->name('farmer_profile');
    Route::get('user/profile/{id}', 'user_profile')->name('user_profile');
    Route::get('user/details/{id}', 'user_details')->name('user_details');
    Route::get('/search', 'admin_search')->name('admin_search');
    Route::get('/contact-messages',  'contact_messages')->name('admin.contact_messages');

});
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::get('/user/dashboard', fn() => view('dashboards.user'))
    ->middleware(['auth', 'verified', 'check.session:customer'])
    ->name('user.dashboard');

Route::get('/farmer/dashboard', fn() => view('dashboards.farmer'))
    ->middleware(['auth', 'verified', 'check.session:farmer'])
    ->name('farmer.dashboard');

Route::get('/admin/dashboard', fn() => view('dashboards.admin'))
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');
/*
|--------------------------------------------------------------------------
| Farmer Routes (Protected by FarmerLoginCheck Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['farmer.check'])->group(function () {

    Route::controller(FarmerController::class)->group(function () {
        Route::get('/farmer/home/page', 'f_home')->name('f_home');
        Route::get('/farmer/search', 'searchCrops')->name('farmer.search');
        Route::get('/farmer/bid/messages', 'farm_bid_messages')->name('farm_bid_messages');

        // Confirmations
        Route::get('/farmer/confirm/form/{id}', 'confirm_form')->name('confirm_form');
        Route::get('/farmer/confirm/crops', 'confirm_crops')->name('confirm_crops');
        Route::get('/farmer/confirm/delete/{id}', 'delete_confirm')->name('delete_confirm');

        // Profile & Settings
        Route::get('/farmer/profile/{f_username}', 'fa_profile')->name('fa_profile');
        Route::post('/farmer/profile/update', 'updateProfile')->name('update_farmer');
        Route::get('/farmer/settings', 'f_settings')->name('f_settings');

        // Verification & Logout
        Route::post('/farmer/nid/verification', 'NID_verification')->name('NID_verification');
        Route::post('/farmer/logout', 'logout')->name('farmer.logout');

        // Customer info
        Route::get('/farmer/customer/{username}', 'customer_profile')->name('customer_profile');
    });

    /*
    |--------------------------------------------------------------------------
    | Farm Crop Routes (also under FarmerLoginCheck)
    |--------------------------------------------------------------------------
    */
    Route::controller(FarmCropController::class)->group(function () {
        Route::get('/farmer/crops/import', 'create')->name('crop_import');
        Route::post('/farmer/crops/store', 'store')->name('crop_store');
        Route::get('/farmer/crops/manage', 'index')->name('crop_manage');
        Route::get('/farmer/crops/edit/{id}', 'edit')->name('crop_edit');
        Route::put('/farmer/crops/update/{id}', 'update')->name('crop_update');
        Route::get('/farmer/crops/delete/{id}', 'destroy')->name('crop_delete'); // ✅ renamed
        Route::get('/farmer/crops/status/{id}', 'toggleStatus')->name('crop_status');
    });

    /*
    |--------------------------------------------------------------------------
    | Farmer Order Routes
    |--------------------------------------------------------------------------
    */
    Route::controller(OrderController::class)->group(function () {
        Route::get('/farmer/orders', 'farmOrderMessages')->name('farmer_orders'); // ✅ Orders button target
        Route::get('/customer/orders', 'custOrderMessages')->name('customer_orders');
        Route::get('/order/payment/{id}', 'paymentForm')->name('farmer_order_payment_form');
        Route::post('/order/manual/payment', 'manuallyPayment')->name('farmer_order_manual_payment');
    });
});
/*
|--------------------------------------------------------------------------
| Buyer Routes
|--------------------------------------------------------------------------
*/
Route::controller(BuyerController::class)->group(function () {
    Route::get('/customer/profile/{c_username}', 'cust_profile')->name('cust_profile');
    Route::get('/confirm/message', 'c_message')->name('c_message');
    Route::get('/customer', 'c_settings')->name('c_settings');
    Route::post('/customer/registerUpdate', 'customerRegisterUpdate')->name('customerRegisterUpdate');
    Route::get('/farmer/profile/check/{f_username}', 'farm_profile')->name('farm_profile');
    Route::post('/buyer/logout',  'logout')->name('buyer.logout');
});

// Wishlist Routes
Route::controller(WishlistController::class)->group(function () {
    Route::get('/customer/wishlist/save/{id}', 'wishlist_db')->name('wishlist_db');
    Route::get('/customer/wishlist/{c_username}', 'wishlist')->name('wishlist');
    Route::get('/wishlist/remove/{id}', 'wishlist_remove')->name('wishlist_remove');
});

// Bid Routes
Route::controller(BidController::class)->group(function () {
    Route::get('/bid/model/{id}', 'Bid_model')->name('Bid_model');
    Route::post('/Bid/message', 'bid_msg_save')->name('bid_msg_save');
    Route::post('/Bid/message/save', 'bid_msg_saved')->name('bid_msg_saved');
    Route::get('/bid/delete/{id}/{crop_id}', 'bid_delete')->name('bid_delete');
    Route::post('/pay/confirm/message', 'pay_confirm_message')->name('pay_confirm_message');
});

// Orders for buyers
Route::get('/customer/order/messages', [OrderController::class, 'custOrderMessages'])->name('cust_order_messages');
Route::get('/order/payment/form/{id}', [OrderController::class, 'paymentForm'])->name('payment_form');
Route::post('/payment/manually', [OrderController::class, 'manuallyPayment'])->name('manually_payment');

// ================= Invoice Routes =================
Route::controller(InvoiceController::class)->group(function () {
    Route::get('/bid_details/download/invoices/{id}', 'bids_download_invoice')->name('bids_download_invoice');
    Route::get('/Pay_Confirm/download/invoice/{id}', 'pay_confirm_download_invoice')->name('pay_confirm_download_invoice');
    Route::get('/invoice/order/{id}', 'order_download_invoice')->name('order_download_invoice');
});