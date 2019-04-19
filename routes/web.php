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

Route::get('/', 'LeagueController@index');
Route::get('/table', 'LeagueController@show_tables');
Route::get('/prediction', 'LeagueController@prediction');
Route::get('/weekly', 'LeagueController@weekly_results');
Route::post('/weekly', 'LeagueController@simulate_weekly_res');
Route::get( '/all', 'LeagueController@match_results');
Route::post( '/all', 'LeagueController@simulate_all_res');
