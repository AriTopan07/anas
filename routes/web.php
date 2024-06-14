<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\ButtonController;
use App\Http\Controllers\Data\CategoryController;
use App\Http\Controllers\Data\GoodReceiveController;
use App\Http\Controllers\Data\GoodsController;
use App\Http\Controllers\Data\GoodsPickController;
use App\Http\Controllers\Data\ReportController;
use App\Http\Controllers\Data\SupplierController;
use App\Http\Controllers\Data\UnitController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'login']);
Route::post('login', [LoginController::class, 'check_login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// URL::forceScheme('https');
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::get('/create-section', [SectionController::class, 'section']);
    Route::get('/section/edit/{id}', [SectionController::class, 'edit']);
    Route::post('/section/update/{id}', [SectionController::class, 'update']);
    Route::post('/section/store', [SectionController::class, 'store']);

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::post('users/update/{id}', [UserController::class, 'update'])->name('users.update');

    // Group
    Route::get('group', [GroupController::class, 'index'])->name('group.index');
    Route::post('group/store', [GroupController::class, 'store'])->name('group.store');
    Route::get('group/{id}', [GroupController::class, 'show'])->name('group.show');
    Route::put('group/{id}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('group/{id}', [GroupController::class, 'destroy'])->name('group.delete');

    // Menu
    Route::get('/menu/api/{id}', [MenuController::class, 'menuApi']);
    Route::post('/menu/store', [MenuController::class, 'store']);
    Route::post('/menu/update/{id}', [MenuController::class, 'update']);

    // Master Aksi
    Route::get('action', [ActionController::class, 'index'])->name('action.index');
    Route::post('action/store', [ActionController::class, 'store'])->name('action.store');

    // Button
    Route::get('button', [ButtonController::class, 'index'])->name('button.index');
    Route::post('button', [ButtonController::class, 'update'])->name('button.update');

    // Hak Akses Menu
    Route::get('permission/data-akses/{id}', [PermissionController::class, 'data_akses'])->name('permission.data-akses');
    Route::post('permission/data-akses/edit_akses', [PermissionController::class, 'edit_akses'])->name('permission.edit-akses');
    Route::post('permission/data-akses/all_access', [PermissionController::class, 'all_access'])->name('permission.all-akses');

    // Units
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::post('/units/create', [UnitController::class, 'store'])->name('units.create');
    Route::get('/units/{id}', [UnitController::class, 'show'])->name('units.show');
    Route::put('/units/{id}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{id}', [UnitController::class, 'destroy'])->name('units.delete');

    // Kategory
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.create');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');

    // Supplier
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers/create', [SupplierController::class, 'store'])->name('suppliers.create');
    Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.delete');

    // Goods receives
    Route::get('/goods-receives', [GoodReceiveController::class, 'index'])->name('goods-receives.index');
    Route::post('/goods-receives/create', [GoodReceiveController::class, 'create'])->name('goods-receives.create');
    Route::get('/goods-receives/{id}', [GoodReceiveController::class, 'show'])->name('goods-receives.show');
    Route::post('/goods-receives/update/{id}', [GoodReceiveController::class, 'update'])->name('goods-receives.update');
    Route::post('/goods-receives/{id}', [GoodReceiveController::class, 'accept'])->name('goods-receives.accept');
    Route::delete('goods-receives/{id}', [GoodReceiveController::class, 'destroy'])->name('goods-receives.delete');

    // Goods pickings
    Route::get('/goods-picking', [GoodsPickController::class, 'index'])->name('goods-picking.index');
    Route::post('/goods-picking/create', [GoodsPickController::class, 'create'])->name('goods-picking.create');
    Route::get('/goods-picking/{id}', [GoodsPickController::class, 'show'])->name('goods-picking.show');
    Route::post('/goods-picking/update/{id}', [GoodsPickController::class, 'update'])->name('goods-picking.update');
    Route::post('/goods-picking/{id}', [GoodsPickController::class, 'accept'])->name('goods-picking.accept');
    Route::delete('goods-picking/{id}', [GoodsPickController::class, 'destroy'])->name('goods-picking.delete');
    Route::post('/check-stock', [GoodsPickController::class, 'checkStock'])->name('check-stock');

    // goods
    Route::get('/goods', [GoodsController::class, 'index'])->name('goods.index');
    Route::post('/goods/create', [GoodsController::class, 'create'])->name('goods.create');
    Route::get('/goods/{id}', [GoodsController::class, 'show'])->name('goods.show');
    Route::post('/goods/{id}', [GoodsController::class, 'update'])->name('goods.update');
    Route::post('/goods/terima/{id}', [GoodsController::class, 'terima'])->name('goods.terima');
    Route::delete('/goods/{id}', [GoodsController::class, 'destroy'])->name('goods.delete');

    // reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports-excel/{type}/{date_start}/{date_end}', [ReportController::class, 'download_excel'])->name('reports.excel');
});
