<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudUserController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ForgotPasswordController;
// Thêm route
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('forgot-password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'processRequest'])->name('process-forgot-password');

// Debug route để xem tất cả các route
Route::get('/debug-routes', function () {
    $routes = Route::getRoutes();
    $routeList = [];
    
    foreach ($routes as $route) {
        $routeList[] = [
            'uri' => $route->uri(),
            'methods' => $route->methods(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
            'middleware' => implode(', ', $route->middleware())
        ];
    }
    
    return $routeList;
});

// Debug Auth status
Route::get('/auth-status', function () {
    return [
        'logged_in' => Auth::check(),
        'user' => Auth::check() ? Auth::user()->email : 'Not logged in'
    ];
});

// Các route không yêu cầu đăng nhập
Route::get('/', [CrudUserController::class, 'index'])->name('index');
Route::get('login', [CrudUserController::class, 'login'])->name('login');
Route::post('login', [CrudUserController::class, 'authUser'])->name('user.authUser');
Route::get('create', [CrudUserController::class, 'createUser'])->name('user.createUser');
Route::post('create', [CrudUserController::class, 'postUser'])->name('user.postUser');

// QUAN TRỌNG: Route đặt lại mật khẩu PHẢI đặt NGOÀI middleware crud_user
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password', [PasswordResetController::class, 'processForgotPassword'])->name('password.process.forgot');

// Các route yêu cầu đăng nhập
Route::middleware(['crud_user'])->group(function () {
    Route::get('dashboard', [CrudUserController::class, 'dashboard']);
    Route::get('read', [CrudUserController::class, 'readUser'])->name('user.readUser');
    Route::get('delete', [CrudUserController::class, 'deleteUser'])->name('user.deleteUser');
    Route::get('update', [CrudUserController::class, 'updateUser'])->name('user.updateUser');
    Route::post('update', [CrudUserController::class, 'postUpdateUser'])->name('user.postUpdateUser');
    Route::get('list', [CrudUserController::class, 'listUser'])->name('user.list');
    Route::get('signout', [CrudUserController::class, 'signOut'])->name('signout');
    Route::get('/ratings', [RatingController::class, 'index'])->name('ratings.index');
    
    Route::get('/thongtincanhan', [UserController::class, 'show'])->name('thongtincanhan.show');
    Route::post('/thongtincanhan/update', [UserController::class, 'update'])->name('thongtincanhan.update');
    
    /// Quên mật khẩu - KHÔNG YÊU CẦU ĐĂNG NHẬP
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('forgot-password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'processRequest'])->name('process-forgot-password');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');});
