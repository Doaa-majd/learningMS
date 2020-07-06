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

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'as' => 'admin.',
], function(){
    Route::prefix('categories')->as('categories.')->group(function(){

        Route::get('/','CategoriesController@index')->name('index');
        Route::get('create','CategoriesController@create')->name('create');
        Route::get('{id}','CategoriesController@show')->name('show');
        Route::put('{id}','CategoriesController@update')->name('update');
        Route::get('{id}/edit','CategoriesController@edit')->name('edit');
        Route::post('/','CategoriesController@store')->name('store');
        Route::delete('{id}/delete','CategoriesController@delete')->name('delete');

        Route::delete('CategoriesDeleteAll', 'CategoriesController@deleteAll')->name('deleteAll');
    });

    Route::resource('courses','CourseController');

    Route::prefix('sections')->as('sections.')->group(function(){
        Route::post('section','SectionController@store')->name('store');
        Route::put('section','SectionController@update')->name('update');
        Route::delete('section/{id}','SectionController@delete')->name('delete');

    });

    Route::prefix('lectures')->as('lectures.')->group(function(){
        Route::get('{id}/content','LectureController@content')->name('content');
        Route::post('lecture','LectureController@store')->name('store');
        Route::put('lecture','LectureController@update')->name('update');
        Route::delete('lecture/{id}','LectureController@delete')->name('delete');

    });


});

