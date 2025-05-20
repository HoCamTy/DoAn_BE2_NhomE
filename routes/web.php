<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ResetPasswordController;

use Illuminate\Support\Facades\Auth;

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
Route::get('/', function () {
    if (Auth::guard('web')->check()) {
        return redirect()->route('admin.dashboard');
    }
    if (Auth::guard('customer')->check()) {
        return redirect()->route('customer.dashboard');
    }
    return redirect()->route('login');
})->name('home');
// Profile routes
    

Route::get('/profile', [CrudUserController::class, 'showProfile'])->name('profile');
Route::post('/profile', [CrudUserController::class, 'updateProfile']);
// Reset password routes
Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
