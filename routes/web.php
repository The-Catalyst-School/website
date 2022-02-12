<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
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

Route::get('/courses', [CourseController::class, 'index'])
  ->name('web.course.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])
  ->name('web.course.show');

Route::get('/workshops', [WorkshopController::class, 'index'])
  ->name('web.workshop.index');
Route::get('/workshops/{slug}', [WorkshopController::class, 'show'])
  ->name('web.workshop.show');

Route::get('/courses/{c_slug}/lessons/{s_slug}', [LessonController::class, 'show'])
  ->name('web.lesson.show');

Route::get('/events/calendar/{date?}', [EventController::class, 'index'])
  ->name('web.event.index');
Route::get('/events/list/{date?}', [EventController::class, 'list'])
  ->name('web.event.list');

Route::get('/profile', [ProfileController::class, 'show'])->name('web.profile');

Route::get('/{slug}', [PageController::class, 'show'])->name('web.page.show');
Route::get('/', [PageController::class, 'home'])->name('web.index');
