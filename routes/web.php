<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\PermissionController;
use App\Http\Controllers\Master\RolesController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['guest'])->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'registerStore');
        Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
        Route::post('/forgot-password', 'sendResetPasswordLinkEmail')->name('password.email');
        Route::get('/reset-password/{token}', 'resetPasswordWithToken')->name('password.reset');
        Route::put('/reset-password-update/{token}', 'resetPasswordUpdate')->name('password.update');

    });

});

Route::controller(AuthController::class)->group(function () {
    Route::get('/email/verify', 'verificationView')->name('verification.notice')->middleware('auth');
    Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify')->middleware(['signed']);
    Route::post('/email/resend', 'resendEmail')->name('verification.resend')->middleware(['auth', 'throttle:6,1']);
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Auth
    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout')->name('logout');
    });

    // Home
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
    });

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::put('/profile/{id}', 'update')->name('profile.update');
        Route::get('/change-password', 'changePasswordView')->name('change-password');
        Route::post('/change-password', 'updatePassword')->name('change-password.update');
    });

    // Master
    Route::prefix('master')->group(function () {

        // User
        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('users');
            Route::post('/users', 'store')->name('users.store');
            Route::get('/users/show/{id}', 'show')->name('users.show');
            Route::put('/users/update/{id}', 'update')->name('users.update');
            Route::delete('/users/delete/{id}', 'destroy')->name('users.destroy');
            Route::get('/users/login-as/{id}', 'loginAs')->name('users.login-as');
        });

        // Role
        Route::controller(RolesController::class)->group(function () {
            Route::get('/roles', 'index')->name('roles');
            Route::post('/roles', 'store')->name('roles.store');
            Route::get('/roles/show/{id}', 'show')->name('roles.show');
            Route::put('/roles/update/{id}', 'update')->name('roles.update');
            Route::delete('/roles/delete/{id}', 'destroy')->name('roles.destroy');
            Route::get('/roles/permissions/{id}', 'rolePermission')->name('roles.permissions');
            Route::put('/roles/permissions/{id}', 'rolePermissionUpdate')->name('roles.permissions.update');
        });

        // // Permission
        Route::controller(PermissionController::class)->group(function () {
            Route::get('/permissions', 'index')->name('permissions');
            Route::post('/permissions', 'store')->name('permissions.store');
            Route::get('/permissions/show/{id}', 'show')->name('permissions.show');
            Route::put('/permissions/update/{id}', 'update')->name('permissions.update');
            Route::delete('/permissions/delete/{id}', 'destroy')->name('permissions.destroy');
        });

    });
});
