<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LessonController;

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

Route::get('/courses', [CourseController::class, 'index'])
  ->name('web.course.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])
  ->name('web.course.show');

Route::get('/courses/{c_slug}/lessons/{s_slug}', [LessonController::class, 'show'])
  ->name('web.lesson.show');


Route::get('/{slug}', [PageController::class, 'show'])->name('web.page.show');
Route::get('/', [PageController::class, 'home'])->name('web.index');
