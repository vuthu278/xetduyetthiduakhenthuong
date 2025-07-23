<?php
/**
 * Created by PhpStorm .
 * User: trungphuna .
 * Date: 12/4/21 .
 * Time: 7:12 AM .
 */

Route::group(['namespace' => 'Auth','prefix' => 'admin'], function(){
    Route::get('login','BackendLoginController@getLogin')->name('get_admin.login');
    Route::post('login','BackendLoginController@postLogin');
    Route::get('logout','BackendLoginController@logout')->name('get_admin.logout');
});


Route::group(['namespace' => 'Backend' , 'prefix' => 'admin', 'middleware' => 'checkLoginAdmin'], function (){
    Route::get('','BackendController@index')->name('backend.index')->middleware('checkRuleUser');
    Route::get('dashboard','BackendController@dashboard')->name('backend.dashboard')->middleware('checkRuleUser');

    Route::group(['prefix' => 'student'], function (){
        Route::get('','StudentController@index')->name('backend.student.index');
    });

    Route::group(['prefix' => 'semester'], function (){
        Route::get('','SemesterController@index')->name('backend.semester.index');
        Route::get('create','SemesterController@create')->name('backend.semester.create')->middleware('checkRuleUser');
        Route::post('create','SemesterController@store')->name('backend.semester.create')->middleware('checkRuleUser');
        Route::get('update/{id}','SemesterController@edit')->name('backend.semester.update')->middleware('checkRuleUser');
        Route::post('update/{id}','SemesterController@update')->name('backend.semester.update')->middleware('checkRuleUser');
        Route::get('delete/{id}','SemesterController@delete')->name('backend.semester.delete')->middleware('checkRuleUser');
    });

    Route::group(['prefix' => 'user'], function (){
        Route::get('','UserController@index')->name('backend.user.index')->middleware('checkRuleUser');
        Route::get('create','UserController@create')->name('backend.user.create')->middleware('checkRuleUser');
        Route::post('create','UserController@store')->name('backend.user.create')->middleware('checkRuleUser');
        Route::get('update/{id}','UserController@edit')->name('backend.user.update')->middleware('checkRuleUser');
        Route::post('update/{id}','UserController@update')->name('backend.user.update')->middleware('checkRuleUser');
        Route::get('delete/{id}','UserController@delete')->name('backend.user.delete')->middleware('checkRuleUser');
    });

    Route::group(['prefix' => 'appellation'], function (){
        Route::get('','AppellationController@index')->name('backend.appellation.index')->middleware('checkRuleUser');
        Route::get('create','AppellationController@create')->name('backend.appellation.create')->middleware('checkRuleUser');
        Route::post('create','AppellationController@store')->name('backend.appellation.create')->middleware('checkRuleUser');
        Route::get('update/{id}','AppellationController@edit')->name('backend.appellation.update')->middleware('checkRuleUser');
        Route::post('update/{id}','AppellationController@update')->name('backend.appellation.update')->middleware('checkRuleUser');
        Route::get('delete/{id}','AppellationController@delete')->name('backend.appellation.delete')->middleware('checkRuleUser');
    });

    Route::group(['prefix' => 'appellation-register'], function (){
        Route::get('','AppellationRegisterController@index')->name('backend.appellation_register.index')->middleware('checkRuleUser');
        Route::get('create','AppellationRegisterController@create')->name('backend.appellation_register.create')->middleware('checkRuleUser');
        Route::post('create','AppellationRegisterController@store')->name('backend.appellation_register.create')->middleware('checkRuleUser');
        Route::get('update/{id}','AppellationRegisterController@edit')->name('backend.appellation_register.update')->middleware('checkRuleUser');
        Route::post('update/{id}','AppellationRegisterController@update')->name('backend.appellation_register.update')->middleware('checkRuleUser');
        Route::get('delete/{id}','AppellationRegisterController@delete')->name('backend.appellation_register.delete')->middleware('checkRuleUser');
    });

    Route::group(['prefix' => 'account'], function (){
        Route::get('','AdminAccountController@index')->name('backend.account.index')->middleware('checkRuleUser');
        Route::get('create','AdminAccountController@create')->name('backend.account.create')->middleware('checkRuleUser');
        Route::post('create','AdminAccountController@store')->name('backend.account.create')->middleware('checkRuleUser');
        Route::get('update/{id}','AdminAccountController@edit')->name('backend.account.update')->middleware('checkRuleUser');
        Route::post('update/{id}','AdminAccountController@update')->name('backend.account.update')->middleware('checkRuleUser');
        Route::get('delete/{id}','AdminAccountController@delete')->name('backend.account.delete')->middleware('checkRuleUser');
    });


    Route::group(['prefix' => 'department'], function (){
        Route::get('','DepartmentController@index')->name('backend.department.index')->middleware('checkRuleUser');
        Route::get('create','DepartmentController@create')->name('backend.department.create')->middleware('checkRuleUser');
        Route::post('create','DepartmentController@store')->name('backend.department.create')->middleware('checkRuleUser');
        Route::get('update/{id}','DepartmentController@edit')->name('backend.department.update')->middleware('checkRuleUser');
        Route::post('update/{id}','DepartmentController@update')->name('backend.department.update')->middleware('checkRuleUser');
        Route::get('delete/{id}','DepartmentController@delete')->name('backend.department.delete')->middleware('checkRuleUser');
    });
});
