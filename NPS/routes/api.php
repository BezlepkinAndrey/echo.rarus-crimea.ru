<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'vote'], function () {

    Route::group(['middleware' => 'auth.survey_participant'], function () {
        Route::post('set_assessment/{id}',
            'SurveyController@setAssessment')->where(['id' => '[0-9]+'])->name('setAssessment');
    });

});


Route::group(['prefix' => 'statistic'], function () {

    Route::get('data', 'SurveyController@getStatistic')->name('getStatistic');
    Route::get('data/excel', 'SurveyController@getStatisticInExcel')->name('getStatisticInExcel');

    Route::get('links/new/{count}', 'SurveyController@getNewLinks')->where(['count' => '[0-9]+'])->name('getNewLinks');

});