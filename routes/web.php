<?php

use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductTransactionController;
use App\Http\Controllers\ProfileController;
use App\Models\Carts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[FrontController::class,'index'])->name('front.index');
Route::get('/search',[FrontController::class,'search'])->name('front.search');
Route::get('/details/{products:slug}',[FrontController::class,'details'])->name('front.product.details');
Route::get('/category/{category}',[FrontController::class,'category'])->name('front.category');
// products nama model nya 


Route::get('/dashboard', function () {
    return view('dashboard');
    // return "User id ". Auth::user()->id;
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('product-transaction', ProductTransactionController::class)->middleware('role:owner|buyer');

    Route::resource('/carts',CartsController::class)->middleware('role:buyer');
    // admin dan pembeli bisa mengakses route diatas 
    Route::post('/carts/add/{productid}',[CartsController::class,'store'])->middleware('role:buyer');


    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('/products',ProductsController::class)->middleware('role:owner'); // hanya owner yang bisa akses 
        Route::resource('/categories',CategoryController::class)->middleware('role:owner'); // hanya owner yang bisa akses 
    });
});

require __DIR__.'/auth.php';
