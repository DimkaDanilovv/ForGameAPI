<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\FactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', 'AuthController@register');

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'],
    function($api) {
        $api->get('/users', 'App\Http\Controllers\Admin\AdminUserController@index');
});

Route::delete('deleteFaction', 'FactionController@deleteFaction');
Route::post('createFaction', 'FactionController@createFaction');
Route::put('editFaction', 'FactionController@editFaction');
Route::post('viewFaction', 'FactionController@viewFaction');

Route::post('addUser', 'AdminUserController@addUser');

Route::delete('deletePlayerClass', 'ClassController@deletePlayerClass');
Route::post('createPlayerClass', 'ClassController@createPlayerClass');
Route::put('editPlayerClass', 'ClassController@editPlayerClass');
Route::post('viewPlayerClass', 'ClassController@viewPlayerClass');

Route::delete('deleteLocation', 'LocationController@deleteLoction');
Route::post('createLocation', 'LocationController@createLocation');
Route::put('editLocation', 'LocationController@editLocation');
Route::post('viewLocation', 'LocationController@viewLocation');

Route::delete('deleteBoss', 'BossController@deleteBoss');
Route::post('createBoss', 'BossController@createBoss');
Route::put('editBoss', 'BossController@editBoss');
Route::post('viewBoss', 'BossController@viewBoss');


