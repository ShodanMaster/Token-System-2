<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\loginController;
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

Route::get('login', [loginController::class, 'index'])->name('login');
Route::post('logging-in', [LoginController::class, 'loggingIn'])->name('loggingin');
Route::post('register-user', [LoginController::class, 'registerUser'])->name('registeruser');

Route::middleware('auth:web')->prefix('admin')->name('admin.')->group(function(){
    Route::get('', [AdminController::class, 'index'])->name('index');

    Route::get('counter', [CounterController::class, 'index'])->name('counter');
    Route::get('create-counter', [CounterController::class, 'createCounter'])->name('createcounter');
    Route::post('delete-counter', [CounterController::class, 'deleteCounter'])->name('deletecounter');
    Route::post('update-status', [CounterController::class, 'updateStatus'])->name('updatestatus');

    Route::post('add-token', [AdminController::class, 'addToken'])->name('addtoken');
    Route::get('issue-token', [AdminController::class, 'issueToken'])->name('issuetoken');
    Route::get('clear-session', [AdminController::class, 'clearSession'])->name('clearsession');

    Route::get('logging-out', [LoginController::class, 'loggingOut'])->name('loggingout');
});
