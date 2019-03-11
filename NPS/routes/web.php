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



Route::group(['prefix' => 'vote'], function () {

    Route::group(['middleware' => 'auth.survey_participant'], function () {
        Route::get('/{id}', 'SurveyController@getAssessmentPage');
    });

});

Route::get('/', function () {
    return view('welcome');
});