<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontendController;

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

// Localized Front-end Routes
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localize', 'localizationRedirect']
], function() {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});

Auth::routes(['register' => false]);

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth']
], function () {
    Route::get('logout', [LoginController::class, 'logout']);

    Route::get('/', function () {
        return view('admin');
    });

    Route::get('{any}', function () {
        return view('admin');
    })->where('any', '.*');
});
