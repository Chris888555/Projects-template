<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesFunnelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\FunnelSettingsController;
use App\Http\Controllers\Navs\NavController;
use App\Http\Controllers\NavSettingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;



##########################################################



##########################################################
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

// Shop
Route::get('/{subdomain}/shop', [ProductController::class, 'showShop'])->name('shop');

// Checkout page
Route::get('/{subdomain}/checkout', [CheckoutController::class, 'view'])->name('checkout.view');
Route::post('/{subdomain}/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/{subdomain}/thank-you/{order}', [CheckoutController::class, 'thankYou'])->name('thank-you');



// Order Details
Route::get('/order-details', function (Request $request) {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return app(OrderController::class)->orderShow($request);
})->name('order.details');

Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');


// Product Edit
Route::get('/product-edit', function () {
    if (!Auth::check() || Auth::user()->is_admin != 1) {
        return redirect()->route('login');
    }
    return app(ProductController::class)->showEditProduct();
})->name('product.edit');
Route::put('/product/{id}', [ProductController::class, 'updateProduct'])->name('product.update');


// Upload Products
Route::get('/upload-product', function () {
    if (!Auth::check() || Auth::user()->is_admin != 1) {
        return redirect()->route('login');
    }
    return app(ProductController::class)->showUploadProduct();
})->name('products.create');
Route::post('/upload-product', [ProductController::class, 'uploadProduct'])->name('products.store');
Route::post('store-brand', [ProductController::class, 'storeBrand'])->name('brands.store');


##########################################################

Route::get('/payment-thank-you-page', function () {
    return view('payment-thank-you');
})->name('payment-thank-you-page');

// upload payment method
Route::get('/upload-payment-method', [PaymentMethodController::class, 'create'])->name('payment-method.create');
Route::post('/upload-payment-method', [PaymentMethodController::class, 'store'])->name('payment-method.store');

Route::put('/payment-method/{id}/update', [PaymentMethodController::class, 'update'])->name('payment-method.update');
Route::delete('/payment-method/{id}/delete', [PaymentMethodController::class, 'destroy'])->name('payment-method.destroy');

// payment form
Route::get('/{subdomain}/payment-form', [PaymentController::class, 'create'])->name('payment.form');
Route::post('/{subdomain}/payment/store', [PaymentController::class, 'store'])->name('payment.store');

// Fetch payments of my clients
Route::get('/my-payments', [PaymentController::class, 'myPayments'])->middleware('auth')->name('my-payments');
Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');


Route::get('/nav-settings', [NavSettingController::class, 'index'])->name('nav-settings.index');
Route::put('/nav-settings', [NavSettingController::class, 'update'])->name('nav-settings.update');


Route::get('/funnel-settings', [FunnelSettingsController::class, 'index'])->name('funnel.settings');
Route::post('/funnel-settings/save', [FunnelSettingsController::class, 'save'])->name('funnel.settings.save');


Route::post('/save-video-progress', [VideoController::class, 'saveVideoProgress']);
Route::get('/video-analytics', [VideoController::class, 'showAnalytics'])->name('video.analytics');
Route::delete('/video-analytics/delete-selected', [VideoController::class, 'deleteSelectedAnalytics'])->name('video-analytics.delete');

// Home Page
Route::get('/', function () {
    return view('home');
})->name('home');


// Footer
Route::get('/footer', function () {
    return view('includes.footer'); // <-- Dapat may 'includes.'
})->name('footer');



Route::get('/nav', [NavController::class, 'showNav'])->name('nav');


// Registration 
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


// Google OAuth Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// Student Login 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');



// Dashboad Logout
Route::post('/logout', function () { Auth::logout(); return redirect('/login'); })->name('logout');



// Dashboard
Route::get('/dashboard', function () {
    // Check if the user is authenticated
    if (!Auth::check()) {
        // If not authenticated, redirect to login page
        return redirect()->route('login');
    }
    // If authenticated, return the dashboard view
    return view('dashboard');
})->name('dashboard');


Route::get('/edit-funnel', [SalesFunnelController::class, 'showForm'])->name('edit-funnel');
Route::post('/edit-funnel', [SalesFunnelController::class, 'save'])->name('save-funnel');


Route::get('/academy', [AcademyController::class, 'academy'])->name('academy');



// Marketing Content
Route::get('/upload-marketing', [MarketingController::class, 'upload'])->name('marketing.index');
Route::post('/marketing/store', [MarketingController::class, 'store'])->name('store.marketing');
Route::delete('/marketing/delete/{id}', [MarketingController::class, 'destroy'])->name('delete.marketing');

Route::get('/downloadable-marketing', [MarketingController::class, 'showDownloadable'])->name('marketing.downloadable');


// Upload Playlist
Route::get('/admin/upload-playlist', function () {
    if (!Auth::check() || Auth::user()->is_admin != 1) {
        return redirect()->route('login');
    }
    return app(PlaylistController::class)->create();
})->name('admin.upload-playlist');
Route::post('/admin/upload-playlist', [PlaylistController::class, 'store'])->name('playlists.store');


// Edit Playlist
Route::get('/admin/update-playlist', function () {
    if (!Auth::check() || Auth::user()->is_admin != 1) {
        return redirect()->route('login');
    }
    return app(PlaylistController::class)->edit();
})->name('admin.update-playlist');

// Route for deleting a playlist (still requires id)
Route::delete('/admin/delete-playlist/{id}', [PlaylistController::class, 'destroy'])->name('admin.delete-playlist');

// Route for updating a playlist (requires id)
Route::put('/admin/update-playlist/{id}', [PlaylistController::class, 'update'])->name('admin.update-playlist.submit');



// Forgot Password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'checkEmail'])->name('password.check');
Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');



// User Profile 
Route::middleware(['auth'])->get('profile/upload', [ProfileController::class, 'showUploadForm'])->name('profile.uploadForm');
Route::middleware(['auth'])->post('profile/upload', [ProfileController::class, 'uploadProfilePhoto'])->name('profile.upload');
Route::put('/profile/update-details', [ProfileController::class, 'updateDetails'])->name('profile.update-details');
Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');




// Sales Funnel Setting
Route::middleware(['auth'])->get('/funnel-main', function () {
    $users = User::all();
    return view('funnel-main', compact('users'));
})->name('funnel.main');


// Admin Manage Users
Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manage-users');
Route::post('/users/{user}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
Route::delete('/users/{user}/delete', [AdminController::class, 'deleteUser'])->name('users.delete');
Route::post('/users/{user}/promote', [AdminController::class, 'promoteToAdmin'])->name('users.promoteToAdmin');
Route::post('/users/revert-to-regular/{user}', [AdminController::class, 'revertToRegular'])->name('admin.revertToRegular');
Route::post('/users/{user}/revert-to-pending', [AdminController::class, 'revertToPending'])->name('users.revertToPending');

// In your web.php
Route::post('/users/bulk-action', [AdminController::class, 'bulkAction'])->name('users.bulkAction');







// Admin Login
Route::get('/admin/admin-login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/admin-login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth');



// Edit Subdomain
Route::middleware(['auth'])->get('/subdomain/update/{id}', [SalesFunnelController::class, 'editSubdomain'])->name('update.subdomain');
Route::middleware(['auth'])->post('/subdomain/update/{id}', [SalesFunnelController::class, 'updateSubdomain'])->name('update.subdomain');

Route::get('/page-view', [PageViewController::class, 'pageViewAnalytics'])->name('pageView.analytics');


// Subdomain 
Route::get('/{subdomain}', [SalesFunnelController::class, 'showFunnel']);


Route::get('/{subdomain}', [PageViewController::class, 'track']);
