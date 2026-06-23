<?php

use App\Http\Controllers\InvCategoryController;
use App\Http\Controllers\InvLocationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/product', ProductController::class);

Route::get('/inv-category/data', [InvCategoryController::class, 'data'])->name('inv-category.data');
Route::resource('/inv-category', InvCategoryController::class);

Route::get('/inv-location/data', [InvLocationController::class, 'data'])->name('inv-location.data');
Route::resource('/inv-location', InvLocationController::class);

Route::get('/inv-product/data', [App\Http\Controllers\InvProductController::class, 'data'])->name('inv-product.data');
Route::resource('/inv-product', App\Http\Controllers\InvProductController::class);

Route::get('/inv-transaction/data', [App\Http\Controllers\InvTransactionController::class, 'data'])->name('inv-transaction.data');
Route::resource('/inv-transaction', App\Http\Controllers\InvTransactionController::class);

Route::get('/arc-category/data', [App\Http\Controllers\ArcCategoryController::class, 'data'])->name('arc-category.data');
Route::resource('/arc-category', App\Http\Controllers\ArcCategoryController::class);

Route::get('/arc-document/data', [App\Http\Controllers\ArcDocumentController::class, 'data'])->name('arc-document.data');
Route::get('/arc-document/download/{id}', [App\Http\Controllers\ArcDocumentController::class, 'download'])->name('arc-document.download');
Route::resource('/arc-document', App\Http\Controllers\ArcDocumentController::class);

Route::get('/dsr-category/data', [App\Http\Controllers\DsrCategoryController::class, 'data'])->name('dsr-category.data');
Route::resource('/dsr-category', App\Http\Controllers\DsrCategoryController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
