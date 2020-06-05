<?php

use App\Http\Controllers\ProjectsController;
use App\Project;
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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware'=>'auth'], function () {
    // Route::get('/projects', 'ProjectsController@index');
    // Route::get('/projects/create', 'ProjectsController@create');
    // Route::get('/projects/{project}', 'ProjectsController@show');
    // Route::get('/projects/{project}/edit', 'ProjectsController@edit');
    // Route::patch('/projects/{project}', 'ProjectsController@update');
    // Route::delete('/projects/{project}', 'ProjectsController@destroy');
    // Route::post('/projects', 'ProjectsController@store');
    // WTF yang diatas bisa diganti ama ini doang
    Route::resource('projects', 'ProjectsController');


    Route::post('/projects/{project}/tasks', 'ProjectTaskController@store');
    Route::post('/projects/{project}/tasks/{task}', 'ProjectTaskController@update');

    Route::post('/projects/{project}/invite', 'ProjectInvitationController@store');
});

Auth::routes();
