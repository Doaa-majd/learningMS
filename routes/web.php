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
    return view('index');
});

//Route::get('/test/{id}', 'HomeController@test');

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'as' => 'admin.',
    'middleware' => 'auth',
], function(){
    Route::get('/', 'HomeController@index')->name('AdminHome');

    Route::prefix('categories')->as('categories.')->group(function(){

        Route::get('/','CategoriesController@index')->name('index');
        Route::get('create','CategoriesController@create')->name('create');
        Route::get('{category}','CategoriesController@show')->name('show');
        Route::put('{category}','CategoriesController@update')->name('update');
        Route::get('{category}/edit','CategoriesController@edit')->name('edit');
        Route::post('/','CategoriesController@store')->name('store');
        Route::delete('{category}/delete','CategoriesController@delete')->name('delete');

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

    Route::prefix('questions')->as('questions.')->group(function(){

        Route::get('/','QuestionController@index')->name('index');
        Route::put('/update','QuestionController@update')->name('update');
        Route::delete('{id}/delete','QuestionController@delete')->name('delete');

    });

});

// In front side
Route::get('course/{id}', 'CourseController@show')->name('course.show');
Route::get('course/category/{id}', 'CourseController@courseCategory')->name('course.courseCategory');

Route::get('user/instructor', 'UserController@becomeInstructor')->name('user.becomeInstructor')->middleware('auth');
Route::post('user/instructor', 'UserController@store')->name('user.store')->middleware('auth');

Route::post('course/enroll/{id}', 'CourseController@enrollCourse')->name('course.enrollCourse')->middleware('auth');
Route::get('course/enroll/{course}', 'CourseController@showCourse')->name('course.showCourse')->middleware('auth');
Route::get('course/user/Courses', 'CourseController@showUserCourse')->name('course.showUserCourse')->middleware('auth');
Route::post('course/complete/lecture', 'CourseController@completeLecture')->name('course.completeLecture')->middleware('auth');
Route::delete('course/complete/lecture', 'CourseController@uncompleteLecture')->name('course.uncompleteLecture')->middleware('auth');
Route::post('course/rating', 'CourseController@rating')->name('course.rating')->middleware('auth');

Route::get('course/showLecture/{cid}/{lid}', 'CourseController@showLecture')->name('course.showLecture')->middleware('auth');

Route::post('question/add', 'QuestionController@add')->name('question.add');
Route::put('question/update', 'QuestionController@update')->name('question.update');
Route::delete('question/delete', 'QuestionController@delete')->name('question.delete');

Route::get('cart', 'CartController@index')->name('cart');
Route::post('cart', 'CartController@store');
Route::delete('cart/{id}', 'CartController@delete')->name('cart.delete');

Route::get('checkout', 'CheckoutController@index')->name('checkout');
Route::post('checkout', 'CheckoutController@checkout');
Route::post('checkbuynow', 'CheckoutController@buynow')->name('buynow');


//Route::get('orders', 'OrdersController@index')->name('orders');


Route::get('paypal/return', 'CheckoutController@paypalReturn')->name('paypal.return');
Route::get('paypal/buynow/return', 'CheckoutController@paypalBuynowReturn')->name('paypal.buynow.return');
Route::get('paypal/cancel', 'CheckoutController@paypalCancel')->name('paypal.cancel');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
