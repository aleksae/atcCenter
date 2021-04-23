<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtcsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\TraineesController;
use App\Http\Controllers\TrainingRequestsController;

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
Route::get('/data_handling', function () {
    return view('dataHandle');
});
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@login')->middleware('guest')->name('login');   // Login
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->middleware('auth')->name('logout'); // Logout

Route::get('/profile', [ProfileController::class,'index'])->name('profile')->middleware('auth');

Route::get('roles','App\Http\Controllers\RolesController@index')->name('roles');
Route::get('edit_roles/{cid}','App\Http\Controllers\RolesController@edit');
Route::get('update_roles/{cid}','App\Http\Controllers\RolesController@update');
Route::get('notification', 'App\Http\Controllers\DiscordNotification@trainingNotification');
Route::get('send_application', 'App\Http\Controllers\TrainingController@applicationRequest')->middleware('auth')->name('applicationRequest');
Route::post('send_application','App\Http\Controllers\TrainingController@sendApplication')->name('sendApplication');
Route::get('training_applications','App\Http\Controllers\TrainingController@viewApplications')->name('trainingApplications');
Route::get('review_application/{id}/{cid}','App\Http\Controllers\TrainingController@reviewApplication')->name('review_application');
Route::post('review_application','App\Http\Controllers\TrainingController@sendReviewApplication')->name('send_review_application');
Route::get('trainees', 'App\Http\Controllers\TraineesController@traineesList')->middleware('TD')->name('trainees');

Route::get('atcs', 'App\Http\Controllers\AtcsController@index')->middleware('TD')->name('atc_list');
Route::get('edit_airports/{cid}', 'App\Http\Controllers\AtcsController@edit')->middleware('TD');
Route::get('edit_airports', 'App\Http\Controllers\AtcsController@update')->middleware('TD')->name('update_ATC_airports');

Route::get('manage_airports/{cid}', 'App\Http\Controllers\TraineesController@airportsView')->middleware('TD');
Route::get('manage_airports','App\Http\Controllers\TraineesController@airportUpdate')->middleware('TD')->name('update_airports');
Route::get('connections', function () {return view('connections');})->name('connections');
Route::get('issue_solo/{cid}','App\Http\Controllers\TraineesController@soloEdit')->middleware('TD');
Route::post('issue_solo','App\Http\Controllers\TraineesController@soloStore')->middleware('TD')->name('store.solo.request');
Route::get('trainee_profile/{cid}','App\Http\Controllers\TraineesController@viewProfile')->middleware('TD');
Route::get('terminate_training/{cid}', 'App\Http\Controllers\TraineesController@terminateTraining')->middleware('TD');

Route::get('request_training', 'App\Http\Controllers\TrainingRequestsController@show')->middleware('Trainee')->name('request.training');
Route::post('request_training', 'App\Http\Controllers\TrainingRequestsController@store')->middleware('Trainee')->name('store.request');
Route::get('training_requests', 'App\Http\Controllers\TrainingRequestsController@mentorShow')->middleware('Mentor')->name('training.requests');
Route::get('edit_request/{id}', 'App\Http\Controllers\TrainingRequestsController@editRequest')->middleware('Mentor')->name('edit.request');
Route::post('edit_request', 'App\Http\Controllers\TrainingRequestsController@storeEditRequest')->middleware('Mentor')->name('store.edit.request');
Route::get('delete_request/{id}', 'App\Http\Controllers\TrainingRequestsController@deleteRequest')->middleware('Trainee')->name('delete.request');

Route::get('my_mentor_sessions', 'App\Http\Controllers\TrainingRequestsController@mentorSessionShow')->middleware('Mentor')->name('mentor.sessions');
Route::get('cancel_session/{id}/{start_old}/{end_old}', 'App\Http\Controllers\TrainingRequestsController@cancelSession')->middleware('Mentor');

Route::get('add_log/{id}/{cid}', 'App\Http\Controllers\TrainingRequestsController@trainingLog')->middleware('Mentor')->name('add.log');
Route::post('add_log', 'App\Http\Controllers\TrainingRequestsController@logStore')->middleware('Mentor')->name('store.log');
Route::get('progress', 'App\Http\Controllers\TrainingRequestsController@progress')->middleware('Mentor')->name('progress');
Route::post('submit_rate', 'App\Http\Controllers\TrainingRequestsController@submitRate')->middleware('Mentor');

Route::get('mentor_reviews', 'App\Http\Controllers\TrainingRequestsController@mentorReviews')->middleware('Mentor');
Route::get('mentor_reviews_all', 'App\Http\Controllers\TrainingRequestsController@mentorReviewsAll')->middleware('TD');

Route::get('reviews', function () {
    return view('reviews.forms');
});

Route::get('roster/{id}', 'App\Http\Controllers\EventsController@rosterView')->middleware('Event');
Route::post('store_roster/{id}', 'App\Http\Controllers\EventsController@rosterStore')->name('roster.store')->middleware('Event');

Route::get('bookings', 'App\Http\Controllers\BookingsController@index')->middleware('ATC')->name('bookings');
Route::post('bookings', 'App\Http\Controllers\BookingsController@create')->middleware('ATC')->name('create_booking');
Route::get('delete_booking/{id}', 'App\Http\Controllers\BookingsController@delete')->middleware('ATC');

Route::get('create_event', 'App\Http\Controllers\EventsController@createEventShow')->middleware('Event');
Route::post('create_event', 'App\Http\Controllers\EventsController@createEvent')->middleware('Event')->name('create.event');
Route::get('events', 'App\Http\Controllers\EventsController@show')->middleware('auth')->name('events');
Route::get('report_avlb/{id}', 'App\Http\Controllers\EventsController@avlbShow')->middleware('auth');
Route::post('report_avlb', 'App\Http\Controllers\EventsController@avlbStore')->middleware('auth')->name('report.avlb');
Route::get('update_avlb/{id}', 'App\Http\Controllers\EventsController@updateAvlbShow')->middleware('auth');
Route::post('update_avlb/{id}', 'App\Http\Controllers\EventsController@avlbUpdate')->middleware('auth')->name('update.avlb');

Route::get('solo', 'App\Http\Controllers\AtcsController@soloShow')->middleware('guest');



