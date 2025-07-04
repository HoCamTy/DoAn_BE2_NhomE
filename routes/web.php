<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\CustomerRatingController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ResetPassword;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\CustomerRating;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PaymentController;
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
// // admin routes
// Route::middleware(['auth:web'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');

//     Route::resource('services', ServiceController::class);
//     // Route::resource('appointments', AppointmentController::class);
// });

// customer routes
// Route::middleware(['auth:customer'])->prefix('customer')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('customer.dashboard');
//     })->name('customer.dashboard');

//     Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('customer.appointments');
//     // ...
// });

// Route::prefix('admin')->group(function () {
//     Route::resource('customers', CustomerController::class);
//     Route::resource('staffs', StaffController::class);
// });

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); 
})->name('admin.dashboard');


// Route::get('/admin/customers', [CustomerController::class, 'index'])->name('customers.index');

Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');


Route::resource('payments', PaymentController::class);

// Public routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');
Route::post('/register', [RegisterController::class, 'register']);
// Protected admin routes
Route::middleware(['checkauth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

   Route::resource('services', ServiceController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('staffs', StaffController::class);

    // Other admin routes
});

// Protected customer routes
Route::middleware(['checkauth'])->prefix('customer')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])
        ->name('customer.appointments');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancelAppointment'])
        ->name('customer.appointments.cancel');
    Route::get('/appointments/create', [AppointmentController::class, 'customerCreate'])
        ->name('customer.appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'customerStore'])
        ->name('customer.appointments.store');
    // Other customer routes
});

// Home route
// Route::get('/', function () {
//     if (Auth::guard('web')->check()) {
//         return redirect()->route('admin.dashboard');
//     }
//     if (Auth::guard('customer')->check()) {
//         return redirect()->route('customer.dashboard');
//     }
//     return redirect()->route('login');
// })->name('home');
Route::get('/', [CrudUserController::class, 'index'])->name('index');
Route::get('create', [CrudUserController::class, 'createUser'])->name('user.createUser');


// Profile routes


Route::get('/profile', [CustomerController::class, 'showProfile'])->name('profile');

Route::post('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
// Nếu bạn dùng resource controller:
// Route::resource('customers', CustomerController::class);



// Đăng xuất
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');







// Route::get('/password/reset', [PasswordResetController::class, 'showForm'])->name('password.form');
// Route::post('/password/reset', [PasswordResetController::class, 'handleReset'])->name('password.reset');
Route::get('/password/reset', [ResetPassword::class, 'showForm'])->name('password.form');
Route::post('/password/reset', [ResetPassword::class, 'handleReset'])->name('password.reset');


Route::get('/ratings/create', [CustomerRatingController::class, 'create'])->name('ratings.create');
Route::post('/ratings', [CustomerRatingController::class, 'store'])->name('ratings.store');
Route::get('/ratings', [CustomerRatingController::class, 'index'])->name('ratings.index');

