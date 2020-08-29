<?php

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

Route::get('/logout', function() {
    Session::flush();
});

Route::group(['prefix' => '/'], function () {
    Route::get('/', 'Auth\LoginController@index');
    Route::post('/login', 'Auth\LoginController@login');
});

Route::group(['prefix' => 'admin','middleware' => 'roles','roles' => 'Admin'], function () {
    
    Route::get('dashboard', 'Controller@index');

    Route::get('/user', 'Controller@userGet');
    Route::get('/user-details/{id}', 'Controller@userDetails');
    Route::get('/survey-category', 'SurveyController@surveyCategory');
    Route::post('/survey-category', 'SurveyController@surveyCategoryPost');
    Route::get('/survey-sub-category', 'SurveyController@surveySubCategory');
    Route::post('/survey-sub-category', 'SurveyController@surveySubCategoryPost');
    Route::get('/survey/{id?}', 'SurveyController@Survey');
    Route::post('/survey', 'SurveyController@surveyPost');
    Route::get('/survey-details/{id}', 'SurveyController@surveyDetails');
    Route::get('/survey-questions/{id}', 'SurveyController@surveyQuestions');
    Route::get('/survey-question-order-update/{survey}/{id}/{current}/{value}', 'SurveyController@questionOrderUpdate');
    Route::get('/survey-question', 'SurveyQuestionController@question');
    Route::post('/survey-question/{id?}', 'SurveyQuestionController@questionPost');
    Route::post('/surveyQuestion/{id?}', 'SurveyQuestionController@surveyQuestion');
    Route::post('/survey-answer', 'SurveyQuestionController@surveyAnswer');
    Route::get('/get-answer', 'SurveyQuestionController@getAnswer');
    Route::get('/get-question', 'SurveyQuestionController@getQuestion');
    Route::get('/edit-temp-question/{id}', 'SurveyQuestionController@editTempQuestion');
    Route::post('/temp-question-edit', 'SurveyQuestionController@tempQuestionEdit');
    Route::get('/delete-temp-question/{id}', 'SurveyQuestionController@deleteTempQuestion');
    Route::get('/delete-temp-question-answer/{id}/{sub}', 'SurveyQuestionController@deleteTempQuestionAnswer');
    Route::get('/delete-answer/{id}', 'SurveyQuestionController@deleteAnswer');
    Route::get('/submit-question', 'SurveyQuestionController@submitQuestion');
    Route::post('/publish-survey/{id?}', 'SurveyController@publishSurvey');
    Route::get('/cost', 'SurveyController@cost');
    Route::post('/cost-post', 'SurveyController@costPost');
    Route::get('/test', 'SurveyController@SendSms');
    Route::post('/grid-question-submit', 'SurveyQuestionController@gridQuestionSubmit');
    Route::get('/delete-QA/{id}/{type}', 'SurveyQuestionController@DeleteQA');
});