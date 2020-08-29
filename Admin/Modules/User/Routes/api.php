<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware'=>'apiRequest'], function () {
    
    Route::post('/login', 'UserController@login');
    Route::post('/register', 'UserController@register');
    Route::get('/check-status/{id}', 'UserController@checkStatus');
    Route::post('/verify', 'UserController@verify');
    Route::get('/profile/{id}/{pro}', 'UserController@profile');
    Route::get('/categories', 'UserController@categories');
    Route::get('/sub-categories/{id}', 'UserController@subCategories');
    Route::get('/survey-get/{id}', 'UserController@surveyGet');
    Route::get('/survey-start/{id}', 'UserController@surveyStart');
    Route::get('/survey-main/{id}', 'UserController@surveyMain');
    Route::post('/survey-fill', 'UserController@surveyFill');
    Route::post('/updateUserData', 'UserController@updateUserData');
    Route::post('/updateUserProfile', 'UserController@updateUserProfile');
    Route::get('/phoneVerify/{id}/{send}/{code?}', 'UserController@phoneVerify');
    Route::post('/forgot-password','UserController@forgotPassword');
    Route::post('/forgot-password-verify', 'UserController@forgotPasswordVerify');
    Route::post('/phone-verification', 'UserController@phoneVerification');
    Route::post('/change-password', 'UserController@changePassword');
    Route::get('/get-data','UserController@getData');
    Route::get('/test', function(){
        $a = [
            'a' => 'abcdef',
            'b' => 'ghijklm'
        ];

        return Crypt::encrypt(3);
    });
    Route::get('/testing/{id}','UserController@testingg');
    Route::any('/curl', function(){
        return redirect('http://103.249.154.246:2200/html/mmlocaltest/try2.php?msg=1010&number=923482010869')->with('success','hello');
    });
    Route::any('/any','UserController@testing');

});