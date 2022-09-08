<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

    // SMS Log Controller
    Route::resource('smslogs', \App\Http\Controllers\Admin\SmsLogsController::class);

    // User Profile Controller
    Route::resource('profiles', \App\Http\Controllers\Admin\UserProfileController::class);
    Route::get('/profile', [\App\Http\Controllers\Admin\UserProfileController::class, 'index'])->name('profile.index');
    Route::post('/change/password', [\App\Http\Controllers\Admin\UserController::class, 'changePassword'])->name('change.password');

    // Device Controller Route
    Route::resource('devices', \App\Http\Controllers\Admin\DevicesController::class);
    Route::get('/devices', [\App\Http\Controllers\Admin\DevicesController::class, 'index'])->name('devices.index');
    Route::get('/devices/status/{id}', [\App\Http\Controllers\Admin\DevicesController::class, 'changeStatus'])->name('devices.status');


    // User Controller Route
    Route::resource('usermanagements', \App\Http\Controllers\Admin\UserController::class);
    Route::get('/usermanagement', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('usermanagement.index');
    Route::get('/usermanagement/status/{id}', [\App\Http\Controllers\Admin\UserController::class, 'changeStatus'])->name('usermanagements.status');
    Route::get('/usermanagement/sms/{id}/configuration', [\App\Http\Controllers\Admin\UserController::class, 'setSMSConfiguration'])->name('usermanagements.sms_configuration');
    Route::post('/usermanagement/sms/configuration/store', [\App\Http\Controllers\Admin\UserController::class, 'storeSMSConfiguration'])->name('sms.configuration.store');

    // Email Template Controller
    Route::resource('emailtemplates', \App\Http\Controllers\Admin\EmailTemplateController::class);
    Route::get('/email-template', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'index'])->name('emailtemplate.index');

    // Role Controller
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::get('/role', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('role.index');
    Route::get('/status/{id}', [\App\Http\Controllers\Admin\RoleController::class, 'changeStatus'])->name('role.status');

});
