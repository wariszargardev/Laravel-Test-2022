<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/upload-image', [App\Http\Controllers\ImageController::class, 'create'])->name('image.create');
    Route::get('/show-image', [App\Http\Controllers\ImageController::class, 'show'])->name('image.show');
    Route::post('/upload-image', [App\Http\Controllers\ImageController::class, 'store'])->name('image.save');
    Route::get('download/{id}', [ImageController::class, 'downloadFile'])->name('downlaod-image');
    Route::get('delete/{id}', [ImageController::class, 'deleteFile'])->name('delte-image');
    Route::get('set-image-visibility/{id}', [ImageController::class, 'setImageVisibility']);
    Route::post('set-image-visibility/{id}', [ImageController::class, 'updateImageVisibility'])->name('update-image-status');

    Route::middleware('image.visibility')->group(function (){
        Route::get('check-visibility/{id}', [ImageController::class, 'downloadFile'])->name('checkVisibility');
    });

});


Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

