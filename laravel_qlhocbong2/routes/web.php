<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;


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

include 'route_admin.php';

Route::get('/', function () {
    return view('welcome');
});


Route::group(['namespace' => 'User'], function(){
    Route::get('login','LoginController@getLogin')->name('get_user.login');
    Route::post('login','LoginController@postLogin');
    Route::get('logout','LoginController@logout')->name('get_user.logout');
});


Route::group(['namespace' => 'User' , 'prefix' => 'user', 'middleware' => 'CheckLoginUser'], function (){
    Route::get('','ProfileController@index')->name('user.index')->middleware('CheckPassUser');
    Route::post('','ProfileController@update')->middleware('CheckPassUser');

    Route::get('password','ProfileController@password')->name('user.password');
    Route::post('password','ProfileController@updatePassword')->name('user.update_password');

    Route::get('update-password','ProfileController@changePassword')->name('user.change_password')->middleware('CheckPassUser');
    Route::post('update-password','ProfileController@updateChangePassword')->middleware('CheckPassUser');

    Route::group(['prefix' => 'appellation-register'], function (){
        Route::get('','AppellationRegisterController@index')->name('user.appellation_register.index');
        Route::get('create','AppellationRegisterController@create')->name('user.appellation_register.create');
        Route::post('create','AppellationRegisterController@store')->name('user.appellation_register.create');
        Route::get('update/{id}','AppellationRegisterController@edit')->name('user.appellation_register.update');
        Route::post('update/{id}','AppellationRegisterController@update')->name('user.appellation_register.update');
        Route::get('delete/{id}','AppellationRegisterController@delete')->name('user.appellation_register.delete');
    });

    Route::group(['prefix' => 'appellation'], function (){
        Route::get('','AppellationController@index')->name('user.appellation.index');
    });
});

// Chatbot Routes
Route::get('/chatbot', [App\Http\Controllers\ChatbotController::class, 'index'])->name('chatbot');
Route::post('/api/chatbot/upload', [App\Http\Controllers\ChatbotController::class, 'upload']);
Route::post('/api/chatbot/ask', [App\Http\Controllers\ChatbotController::class, 'ask']);

//Quên mật khẩu
Route::get('/admin/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('admin.forgot.form');
Route::post('/admin/send-otp', [ForgotPasswordController::class, 'sendOTP'])->name('admin.forgot.sendOTP');

Route::get('/admin/verify-otp', [ForgotPasswordController::class, 'showVerifyOTPForm'])->name('admin.verify.otp.form');
Route::post('/admin/verify-otp', [ForgotPasswordController::class, 'verifyOTP'])->name('admin.verify.otp');

Route::get('/admin/reset-password', [ResetPasswordController::class, 'showForm'])->name('admin.reset.password.form');
Route::post('/admin/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('admin.reset.password');


