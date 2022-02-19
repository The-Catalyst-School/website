<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;

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

// Auth

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('web.login')
    ->middleware('guest');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('web.login.store')
    ->middleware('guest');
Route::delete('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('web.logout');
Route::post('/register', [RegisterController::class, 'store'])
    ->name('web.register.store')
    ->middleware('guest');
Route::get('/register', [RegisterController::class, 'create'])
    ->name('web.register.create')
    ->middleware('guest');

Route::get('/profile/avatar', [ProfileController::class, 'createAvatar'])
  ->name('web.profile.avatar.create')
  ->middleware('auth');

Route::post('/profile/avatar', [ProfileController::class, 'storeAvatar'])
  ->name('web.profile.avatar.store')
  ->middleware('auth');

Route::get('/courses', [CourseController::class, 'index'])
  ->name('web.course.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])
  ->name('web.course.show');

Route::post('/courses/{event_id}', [CourseController::class, 'subscribe'])
  ->name('web.course.subscribe')
  ->middleware('auth');

Route::get('/workshops', [WorkshopController::class, 'index'])
  ->name('web.workshop.index');
Route::get('/workshops/{slug}', [WorkshopController::class, 'show'])
  ->name('web.workshop.show');

Route::post('/workshops/{event_id}', [WorkshopController::class, 'subscribe'])
  ->name('web.workshop.subscribe')
  ->middleware('auth');
Route::delete('/workshops/{event_id}', [WorkshopController::class, 'unsubscribe'])
  ->name('web.workshop.unsubscribe')
  ->middleware('auth');

Route::get('/courses/{c_slug}/lessons/{s_slug}', [LessonController::class, 'show'])
  ->name('web.lesson.show');

Route::get('/events/calendar/{date?}', [EventController::class, 'index'])
  ->name('web.event.index');
Route::get('/events/list/{date?}', [EventController::class, 'list'])
  ->name('web.event.list');

Route::post('/events/{event_id}', [EventController::class, 'subscribe'])
  ->name('web.event.subscribe')
  ->middleware('auth');
Route::delete('/events/{event_id}', [EventController::class, 'unsubscribe'])
  ->name('web.event.unsubscribe')
  ->middleware('auth');

Route::get('/comment/create/{entity}/{id}', [CommentController::class, 'create'])
    ->name('web.comment.create')
    ->middleware('auth');

Route::get('/comment/create/{comment_id}', [CommentController::class, 'edit'])
    ->name('web.comment.edit')
    ->middleware('auth');

Route::post('/comment', [CommentController::class, 'store'])
    ->name('web.comment.store')
    ->middleware('auth');

Route::post('/comment/{comment_id}/update', [CommentController::class, 'update'])
    ->name('web.comment.update')
    ->middleware('auth');

Route::delete('/comment/{comment_id}', [CommentController::class, 'delete'])
    ->name('web.comment.delete')
    ->middleware('auth');

Route::get('/profile', [ProfileController::class, 'overview'])
    ->name('web.profile')
    ->middleware('auth');

Route::get('/profile/courses', [ProfileController::class, 'courses'])
    ->name('web.profile.courses')
    ->middleware('auth');

Route::get('/profile/workshops', [ProfileController::class, 'workshops'])
    ->name('web.profile.workshops')
    ->middleware('auth');

Route::get('/profile/comments', [ProfileController::class, 'comments'])
    ->name('web.profile.comments')
    ->middleware('auth');

Route::get('/{slug}', [PageController::class, 'show'])->name('web.page.show');
Route::get('/', [PageController::class, 'home'])->name('web.index');
