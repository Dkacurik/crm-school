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

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home')
                                           ->middleware('verified');

Route::resource('/tasks', 'TaskController');
Route::get('/all-tasks', 'TaskController@alltasks')->name('tasks.alltasks');

Route::resource('/clients', 'ClientsController');
Route::patch('/clients/{id}/archive', 'ClientsController@archive')->name('clients.archive');

Route::resource('/notes', 'NotesController');

Route::resource('/jobs', 'JobsController');
Route::get('/history-of-jobs', 'JobsController@history')->name('jobs.history');
Route::get('/my-jobs', 'JobsController@myjobs')->name('jobs.myjobs');



Route::resource('/costs', 'CostsController');
Route::patch('/costs/{id}/archive', 'CostsController@archive')->name('costs.archive');

Route::patch('/percentage', 'WorkgroupController@percentage')->name('percentage');
Route::patch('/jobs/{id}/complete', 'JobsController@complete')->name('jobs.complete');
Route::patch('/jobs/{id}/repair', 'WorkgroupController@repair')->name('jobs.repair');
Route::patch('/jobs/{id}/archive', 'JobsController@archive')->name('jobs.archive');
Route::delete('/removepercentage', 'WorkgroupController@removepercentage')->name('removepercentage');

Route::get('/process', 'ProcessesController@showTasks')->name('process');

Route::patch('/process/inprogress/{id}', 'ProcessesController@inProgress')->name('inprogress');
Route::patch('/process/completed/{id}', 'ProcessesController@completed')->name('completed');
Route::patch('/process/newTask/{id}', 'ProcessesController@newTask')->name('newTask');
Route::patch('/process/ajax', 'ProcessesController@ajax')->name('ajax');

