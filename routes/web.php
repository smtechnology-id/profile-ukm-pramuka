<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('index');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/loginPost', [AuthController::class, 'loginPost'])->name('loginPost');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth.middleware:admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/news', [AdminController::class, 'news'])->name('admin.news');
    Route::get('/admin/news/create', [AdminController::class, 'newsCreate'])->name('admin.news.create');
    Route::post('/admin/news/store', [AdminController::class, 'newsStore'])->name('admin.news.store');
    Route::get('/admin/news/edit/{id}', [AdminController::class, 'newsEdit'])->name('admin.news.edit');
    Route::post('/admin/news/update', [AdminController::class, 'newsUpdate'])->name('admin.news.update');
    Route::get('/admin/news/destroy/{id}', [AdminController::class, 'newsDestroy'])->name('admin.news.destroy');

    // Mentor Work
    Route::get('/admin/mentor-work', [AdminController::class, 'mentorWork'])->name('admin.mentor-work');
    Route::get('/admin/mentor-work/create', [AdminController::class, 'mentorWorkCreate'])->name('admin.mentor-work.create');
    Route::post('/admin/mentor-work/store', [AdminController::class, 'mentorWorkStore'])->name('admin.mentor-work.store');
    Route::get('/admin/mentor-work/edit/{id}', [AdminController::class, 'mentorWorkEdit'])->name('admin.mentor-work.edit');
    Route::post('/admin/mentor-work/update', [AdminController::class, 'mentorWorkUpdate'])->name('admin.mentor-work.update');
    Route::get('/admin/mentor-work/destroy/{id}', [AdminController::class, 'mentorWorkDestroy'])->name('admin.mentor-work.destroy');

    // Event
    Route::get('/admin/event', [AdminController::class, 'event'])->name('admin.event');
    Route::get('/admin/event/create', [AdminController::class, 'eventCreate'])->name('admin.event.create');
    Route::post('/admin/event/store', [AdminController::class, 'eventStore'])->name('admin.event.store');
    Route::get('/admin/event/edit/{id}', [AdminController::class, 'eventEdit'])->name('admin.event.edit');
    Route::post('/admin/event/update', [AdminController::class, 'eventUpdate'])->name('admin.event.update');
    Route::get('/admin/event/destroy/{id}', [AdminController::class, 'eventDestroy'])->name('admin.event.destroy');

    // Registration
    Route::get('/admin/registration', [AdminController::class, 'registration'])->name('admin.registration');
    Route::get('/admin/registration/detail/{id}', [AdminController::class, 'registrationDetail'])->name('admin.registration.detail');
});
