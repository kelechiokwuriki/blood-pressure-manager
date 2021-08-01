<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/staff-area', 'StaffAreaController@showStaffArea');
Route::resource('user', 'UserController');


Route::get('/export-observation/{exportType}', 'UserController@exportObservation')->middleware('exportobservation');
Route::get('/export-staffs/{exportType}', 'UserController@exportStaffs')->middleware('exportstaffs');


