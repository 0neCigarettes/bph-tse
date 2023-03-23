<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechController;

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
    return redirect()->route('login');
});

Auth::routes();
Route::group(['prefix' => 'admin', 'middleware' => 'checkRole:0', 'as' => 'admin.'], function () {
    Route::controller(AdminController::class)->group(function ($router) {
        $router->get('/', 'home')->name('home');
        $router->post('/assign-tech/{report_id}', 'assignTech')->name('assignTech');
        $router->get('/users', 'allUsers')->name('allUsers');
        $router->post('/import-xlsx', 'uploadReportExcel')->name('importExcel');
        $router->get('/download-template', 'downloadTemplate')->name('downloadTemplate');
    });
});

Route::group(['prefix' => 'user', 'middleware' => 'checkRole:1', 'as' => 'user.'], function () {
    Route::controller(UserController::class)->group(function ($router) {
        $router->get('/', 'home')->name('home');

        $router->post('/add-report', 'addReport')->name('add-report');
    });
});
Route::group(['prefix' => 'tech', 'middleware' => 'checkRole:2', 'as' => 'tech.'], function () {
    Route::controller(TechController::class)->group(function ($router) {
        $router->get('/', 'home')->name('home');
        $router->post('/solve/{report_id}', 'solve')->name('solve');
    });
});
