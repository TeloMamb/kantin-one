<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'prevent.back', 'role:administrator'])->group(function () {

    /* Pages */
    /* -------------------------------------------------------------------------- */
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/orders', function () {
        return view('orders.index');
    })->name('orders.index');
    /* -------------------------------------------------------------------------- */

    /* User Management */
    /* -------------------------------------------------------------------------- */
    Route::post('/users/search', [UserController::class, 'index'])
        ->name('users.search');

    /* Index & Create */
    /* -------------------------------------------------------------------------- */
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');
    /* -------------------------------------------------------------------------- */

    /* Detail & Edit: pilih pengguna melalui POST */
    /* -------------------------------------------------------------------------- */
    Route::post('/users/detail', [UserController::class, 'selectDetail'])
        ->name('users.select-detail');

    Route::get('/users/detail', [UserController::class, 'show'])
        ->name('users.show');

    Route::post('/users/edit', [UserController::class, 'selectEdit'])
        ->name('users.select-edit');

    Route::get('/users/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::put('/users/edit', [UserController::class, 'update'])
        ->name('users.update');
    /* -------------------------------------------------------------------------- */

    /* Status & Delete */
    /* -------------------------------------------------------------------------- */
    Route::post('/users/status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status');

    Route::post('/users/delete', [UserController::class, 'destroy'])
        ->name('users.destroy');
    /* -------------------------------------------------------------------------- */

    /* Trash, Restore & Permanent Delete */
    /* -------------------------------------------------------------------------- */
    Route::get('/users/trash', [UserController::class, 'trash'])
        ->name('users.trash');

    Route::post('/users/restore', [UserController::class, 'restore'])
        ->name('users.restore');

    Route::post('/users/forcedelete', [UserController::class, 'forceDelete'])
        ->name('users.force-delete');
    /* -------------------------------------------------------------------------- */

    /* Reset Password */
    /* -------------------------------------------------------------------------- */
    Route::post('/users/resetpassword/start', [UserController::class, 'startPasswordReset'])
        ->name('users.resetpassword.start');

    Route::get('/users/resetpassword', [UserController::class, 'editPassword'])
        ->name('users.resetpassword.edit');

    Route::patch('/users/resetpassword', [UserController::class, 'updatePassword'])
        ->name('users.resetpassword.update');
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */

    /* Tenant Management */
    /* -------------------------------------------------------------------------- */
    /* Index & Search */
    /* -------------------------------------------------------------------------- */
    Route::post('/tenants/search', [TenantController::class, 'index'])
        ->name('tenants.search');

    Route::get('/tenants', [TenantController::class, 'index'])
        ->name('tenants.index');
    /* -------------------------------------------------------------------------- */

    /* Create */
    /* -------------------------------------------------------------------------- */
    Route::get('/tenants/create', [TenantController::class, 'create'])
        ->name('tenants.create');

    Route::post('/tenants', [TenantController::class, 'store'])
        ->name('tenants.store');
    /* -------------------------------------------------------------------------- */

    /* Detail */
    /* -------------------------------------------------------------------------- */
    Route::post('/tenants/detail', [TenantController::class, 'selectDetail'])
        ->name('tenants.select-detail');

    Route::get('/tenants/detail', [TenantController::class, 'show'])
        ->name('tenants.show');
    /* -------------------------------------------------------------------------- */

    /* Edit */
    /* -------------------------------------------------------------------------- */
    Route::post('/tenants/edit', [TenantController::class, 'selectEdit'])
        ->name('tenants.select-edit');

    Route::get('/tenants/edit', [TenantController::class, 'edit'])
        ->name('tenants.edit');

    Route::put('/tenants/edit', [TenantController::class, 'update'])
        ->name('tenants.update');
    /* -------------------------------------------------------------------------- */

    /* Status & Delete */
    /* -------------------------------------------------------------------------- */
    Route::post('/tenants/status', [TenantController::class, 'toggleStatus'])
        ->name('tenants.toggle-status');

    Route::post('/tenants/delete', [TenantController::class, 'destroy'])
        ->name('tenants.destroy');
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */

    /* Product Management */
    /* -------------------------------------------------------------------------- */

    /* Index & Search */
    Route::post('/products/search', [ProductController::class, 'index'])
        ->name('products.search');

    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    /* Create */
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    /* Detail */
    Route::post('/products/detail', [ProductController::class, 'selectDetail'])
        ->name('products.select-detail');

    Route::get('/products/detail', [ProductController::class, 'show'])
        ->name('products.show');

    /* Edit */
    Route::post('/products/edit', [ProductController::class, 'selectEdit'])
        ->name('products.select-edit');

    Route::get('/products/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::put('/products/edit', [ProductController::class, 'update'])
        ->name('products.update');

    /* Availability & Delete */
    Route::post('/products/status', [ProductController::class, 'toggleStatus'])
        ->name('products.toggle-status');

    Route::post('/products/delete', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    Route::get('/products/trash', [ProductController::class, 'trash'])
        ->name('products.trash');

    Route::post('/products/restore', [ProductController::class, 'restore'])
        ->name('products.restore');

    Route::post('/products/force-delete', [ProductController::class, 'forceDelete'])
        ->name('products.force-delete');

    /* -------------------------------------------------------------------------- */

});
