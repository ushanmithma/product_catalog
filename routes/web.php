<?php

use App\Http\Controllers\{ProfileController, ProductController};
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::middleware('web', 'auth')->group(function () {
    Route::resource('/products', ProductController::class);
    Route::get('/get-products-table-data', [ProductController::class, 'table'])->name('product-table');

});
