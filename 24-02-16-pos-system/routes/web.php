<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Register;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('sales', Register::class)->missing(function (Request $req) {
    return redirect()->route('sales.index');
});

Route::resource('items', ItemController::class)->missing(function (Request $req){
    return redirect()->route('items.index');
});

Route::put('sales/{id}', [Register::class, 'update'])->name('sales.update');
Route::post('sales/{id}/pay', [Register::class, 'pay'])->name('sales.pay');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
