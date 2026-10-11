<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Backend\BlogController as BackendBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductPageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteAnalyticsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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



Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    // Todo Routes

    Route::prefix('admin')->group(function () {
        Route::get('manage-permissions', [RolePermissionController::class, 'managePermissions'])->name('manage_permissions');
        // Load permissions for a role (AJAX)
        Route::get('roles/{role}/permissions', [RolePermissionController::class, 'getPermissions'])->name('get_permissions');
        Route::post('roles/{role}/permissions', [RolePermissionController::class, 'updatePermissions'])->name('update_permissions');


        Route::prefix('dashboard')->group(function () {
            Route::get('/', [TodoController::class, 'index'])->name('dashboard');
            Route::post('/', [TodoController::class, 'store'])->name('todo.store');
            Route::get('//{id}', [TodoController::class, 'edit'])->name('todo.edit');
            Route::put('//{id}', [TodoController::class, 'update'])->name('todo.update');
            Route::delete('//{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
        });
        Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('profile/settings', [ProfileController::class, 'settings'])->name('settings.index');
        Route::put('profile/settings', [ProfileController::class, 'update'])->name('profile.update');
        //Blog Controller
        Route::prefix('backend')
            ->name('backend.')
            ->group(function () {

                Route::resource(
                    'blogs',
                    BackendBlogController::class
                );
            });
    });
});


//  Route::redirect('/', '/admin/dashboard');
// Home
Route::get('/', function () {
    return view('frontend.pages.home');
})->name('home');


// About
Route::get('/about', function () {
    return view('frontend.pages.about');
})->name('about');


// Services
Route::get('/services', function () {
    return view('frontend.pages.services');
})->name('services');


// Blog
Route::get(
    '/blog',
    [BlogController::class, 'index']
)->name('blog');
Route::get(
    '/blog/{blog}',
    [BlogController::class, 'show']
)->name('blog.view');



// Blog Details
Route::get('/blog/{id}', function ($id) {
    return view('frontend.pages.blog-view', compact('id'));
})->name('blog.view');


// Testimonials
Route::get('/testimonials', function () {
    return view('frontend.pages.testimonials');
})->name('testimonials');


// FAQ
Route::get('/faq', function () {
    return view('frontend.pages.faq');
})->name('faq');


// Contact
Route::get('/contact', function () {
    return view('frontend.pages.contact');
})->name('contact');


// Appointment
Route::get('/appointment', function () {
    return view('frontend.pages.appointment');
})->name('appointment');
