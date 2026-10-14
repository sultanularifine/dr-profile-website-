<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ChamberController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorProfileController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PaymentSettingsController;
use App\Http\Controllers\Admin\PrescriptionController;
use App\Http\Controllers\Admin\PatientMedicalDocumentController as AdminMedicalDocumentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Backend\BlogController as BackendBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConsentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Patient\PaymentController as PatientPaymentController;
use App\Http\Controllers\Patient\MedicalDocumentController;
use App\Http\Controllers\Patient\SslCommerzController;
use App\Http\Controllers\Patient\PrescriptionAccessController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Models\Chamber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Auth::routes();

/*
|--------------------------------------------------------------------------
| Authenticated workspace
|--------------------------------------------------------------------------
| Keep the existing route names where possible so older Blade links continue
| working. Medical and website-management endpoints use separate role groups.
*/
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home.redirect');

Route::post('/privacy/consent', [ConsentController::class, 'store'])->name('privacy.consent');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::match(['GET', 'POST'], '/payments/sslcommerz/success', [SslCommerzController::class, 'success'])->name('sslcommerz.success');
Route::match(['GET', 'POST'], '/payments/sslcommerz/fail', [SslCommerzController::class, 'fail'])->name('sslcommerz.fail');
Route::match(['GET', 'POST'], '/payments/sslcommerz/cancel', [SslCommerzController::class, 'cancel'])->name('sslcommerz.cancel');

Route::middleware('auth')->group(function () {
    // Admin overview: the controller routes patient accounts to the patient area.
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Day-to-day appointment operations. Reception staff may manage bookings.
    Route::middleware('role:Super Admin|Doctor|Receptionist|Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/manual/create', [AppointmentController::class, 'createManual'])->name('appointments.manual.create');
        Route::post('/appointments/manual', [AppointmentController::class, 'storeManual'])->name('appointments.manual.store');
        Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::post('/appointments/{appointment}/manual-join-override', [AppointmentController::class, 'toggleManualJoinOverride'])->name('appointments.join-override');
    });

    Route::middleware('role:Super Admin|Doctor|Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/medical-documents', [AdminMedicalDocumentController::class, 'index'])->name('medical-documents.index');
        Route::get('/medical-documents/{document}/download', [AdminMedicalDocumentController::class, 'download'])->name('medical-documents.download');
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}/proof', [AdminPaymentController::class, 'proof'])->name('payments.proof');
    });
    Route::middleware('role:Super Admin|Doctor')->prefix('admin')->name('admin.')->group(function () {
        Route::put('/payments/{payment}', [AdminPaymentController::class, 'update'])->name('payments.update');
    });

    // Clinical configuration and prescription records are restricted to the doctor/admin.
    Route::middleware('role:Super Admin|Doctor')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/chambers', [ChamberController::class, 'index'])->name('chambers.index');
        Route::post('/chambers', [ChamberController::class, 'store'])->name('chambers.store');
        Route::put('/chambers/{chamber}', [ChamberController::class, 'update'])->name('chambers.update');
        Route::post('/chambers/{chamber}/schedules', [ChamberController::class, 'storeSchedule'])->name('chambers.schedules.store');
        Route::put('/chambers/{chamber}/schedules/{schedule}', [ChamberController::class, 'updateSchedule'])->name('chambers.schedules.update');
        Route::delete('/chambers/{chamber}/schedules/{schedule}', [ChamberController::class, 'destroySchedule'])->name('chambers.schedules.destroy');

        Route::get('/doctor-profile', [DoctorProfileController::class, 'edit'])->name('doctor-profile.edit');
        Route::put('/doctor-profile', [DoctorProfileController::class, 'update'])->name('doctor-profile.update');

        Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
        Route::get('/appointments/{appointment}/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
        Route::post('/appointments/{appointment}/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::put('/prescriptions/{prescription}/publish', [PrescriptionController::class, 'publish'])->name('prescriptions.publish');
        Route::get('/prescriptions/{prescription}/file', [PrescriptionController::class, 'download'])->name('prescriptions.file');
        Route::get('/prescriptions/{prescription}/pdf', [PrescriptionController::class, 'pdf'])->name('prescriptions.pdf');

        // Page-level website content editor: one submenu per existing frontend page.
        Route::prefix('pages')->name('pages.')->controller(PageContentController::class)->group(function () {
            Route::get('/{page}', 'page')->where('page', '[A-Za-z0-9_-]+')->name('edit');
            Route::put('/{page}', 'updatePage')->where('page', '[A-Za-z0-9_-]+')->name('update');
        });

        Route::prefix('page-content')->name('page-content.')->controller(PageContentController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{key}/edit', 'edit')->where('key', '[A-Za-z0-9_.-]+')->name('edit');
            Route::put('/{key}', 'update')->where('key', '[A-Za-z0-9_.-]+')->name('update');
            Route::delete('/{key}', 'destroy')->where('key', '[A-Za-z0-9_.-]+')->name('destroy');
        });
    });

    // System-wide settings and SEO are restricted to Super Admins.
    Route::middleware('role:Super Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/site-settings', [SiteSettingsController::class, 'edit'])->name('site-settings.edit');
        Route::put('/site-settings', [SiteSettingsController::class, 'update'])->name('site-settings.update');
        Route::get('/payment-settings', [PaymentSettingsController::class, 'edit'])->name('payment-settings.edit');
        Route::put('/payment-settings', [PaymentSettingsController::class, 'update'])->name('payment-settings.update');
        Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
        Route::get('/seo/{page}', [SeoController::class, 'edit'])->where('page', '[A-Za-z0-9_-]+')->name('seo.edit');
        Route::put('/seo/{page}', [SeoController::class, 'update'])->where('page', '[A-Za-z0-9_-]+')->name('seo.update');
    });

    // Existing account, roles, and permissions modules.
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::prefix('admin')->group(function () {
        Route::get('manage-permissions', [RolePermissionController::class, 'managePermissions'])->name('manage_permissions');
        Route::get('roles/{role}/permissions', [RolePermissionController::class, 'getPermissions'])->name('get_permissions');
        Route::post('roles/{role}/permissions', [RolePermissionController::class, 'updatePermissions'])->name('update_permissions');
    });

    // Existing dashboard task-list feature, preserved at its original URLs.
    Route::prefix('admin/dashboard')->group(function () {
        Route::post('/', [TodoController::class, 'store'])->name('todo.store');
        Route::get('/{id}/edit', [TodoController::class, 'edit'])->name('todo.edit');
        Route::put('/{id}', [TodoController::class, 'update'])->name('todo.update');
        Route::delete('/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('settings.index');
    Route::put('/profile/settings', [ProfileController::class, 'update'])->name('profile.update');

    // Existing blog CRUD route names and URLs remain unchanged.
    Route::prefix('admin/backend')->name('backend.')->group(function () {
        Route::resource('blogs', BackendBlogController::class);
    });

    // Patient dashboard and records are scoped to the signed-in patient in their controllers.
    Route::middleware('role:Patient')->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/appointments/create', [PatientDashboardController::class, 'createAppointment'])->name('appointments.create');
        Route::get('/availability', [PatientDashboardController::class, 'availability'])->name('availability');
        Route::post('/appointments', [PatientDashboardController::class, 'storeAppointment'])->name('appointments.store');
        Route::get('/appointments/{appointment}/payment', [PatientPaymentController::class, 'create'])->name('payments.create');
        Route::post('/appointments/{appointment}/payment', [PatientPaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments', [PatientPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}/proof', [PatientPaymentController::class, 'proof'])->name('payments.proof');
        Route::get('/medical-documents', [MedicalDocumentController::class, 'index'])->name('documents.index');
        Route::post('/medical-documents', [MedicalDocumentController::class, 'store'])->name('documents.store');
        Route::get('/medical-documents/{document}/download', [MedicalDocumentController::class, 'download'])->name('documents.download');
        Route::post('/appointments/{appointment}/sslcommerz', [SslCommerzController::class, 'initiate'])->name('payments.sslcommerz');
        Route::get('/prescriptions/{prescription}', [PrescriptionAccessController::class, 'show'])->name('prescriptions.show');
        Route::get('/prescriptions/{prescription}/file', [PrescriptionAccessController::class, 'file'])->name('prescriptions.file');
        Route::get('/prescriptions/{prescription}/preview', [PrescriptionAccessController::class, 'preview'])->name('prescriptions.preview');
        Route::get('/prescriptions/{prescription}/pdf', [PrescriptionAccessController::class, 'pdf'])->name('prescriptions.pdf');
    });
});

/* Public website routes. Their paths and primary names are kept stable. */
Route::get('/appointment/book', function () {
    if (auth()->check() && !auth()->user()->hasRole('Patient')) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('patient.appointments.create', request()->only('chamber_id'));
})->name('appointment.book');
Route::get('/', function () {
    // The home page reads active chamber data when clinic tables are installed; otherwise keep the legacy fallback content.
    $chambers = Schema::hasTable('chambers')
        ? Chamber::query()
            ->where('is_active', true)
            ->with(['schedules' => fn ($query) => $query->where('is_active', true)->orderBy('weekday')->orderBy('starts_at')])
            ->orderBy('display_order')
            ->orderBy('name')
            ->get()
        : collect();

    return view('frontend.pages.home', compact('chambers'));
})->name('home');
Route::get('/about', fn () => view('frontend.pages.about'))->name('about');
Route::get('/services', fn () => view('frontend.pages.services'))->name('services');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.view');
Route::get('/testimonials', fn () => view('frontend.pages.testimonials'))->name('testimonials');
Route::get('/faq', fn () => view('frontend.pages.faq'))->name('faq');
Route::get('/contact', fn () => view('frontend.pages.contact'))->name('contact');
Route::get('/appointment', function () {
    // Keep the original appointment page usable before the optional clinic tables are migrated.
    $chambers = Schema::hasTable('chambers')
        ? Chamber::query()
            ->where('is_active', true)
            ->with(['schedules' => fn ($query) => $query->where('is_active', true)->orderBy('weekday')->orderBy('starts_at')])
            ->orderBy('display_order')
            ->orderBy('name')
            ->get()
        : collect();

    return view('frontend.pages.appointment', compact('chambers'));
})->name('appointment');
