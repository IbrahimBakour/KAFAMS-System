<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
//home
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/admin', action: [HomeController::class, 'index'])->name('home.admin');
Route::get('/home/student', [HomeController::class, 'index'])->name('home.student');
Route::get('/home/parent', [HomeController::class, 'index'])->name('home.parent');
//result
Route::resource('results', ResultController::class);

//bulletin
Route::get('/bulletin/admin', [BulletinController::class, 'indexAdmin'])->name('bulletin.indexBulletinAdmin');
Route::get('/bulletin', [BulletinController::class, 'index'])->name('bulletin.indexBulletin');
Route::get('/bulletin/admin/create', [BulletinController::class, 'create'])->name('bulletin.createBulletin');
Route::post('/bulletin/admin/create/store', [BulletinController::class, 'store'])->name('bulletin.store');
Route::get('/bulletin/admin/edit/{id}', [BulletinController::class, 'edit'])->name('bulletin.updateBulletin');
Route::post('/bulletin/admin/update/{id}', [BulletinController::class, 'update'])->name('bulletin.update');
Route::delete('/bulletin/admin/delete/{id}', [BulletinController::class, 'destroy'])->name('bulletin.destroy');
// Route::get('/bulletin/admin/edit', [BulletinController::class, 'edit'])->name('bulletin.updateBulletin');
// Route::get('/bulletin/admin/delete', [BulletinController::class, 'delete'])->name('bulletin.deleteBulletin');
//asing kan ye

//profile
Route::get('/profile', [profileController::class, 'index'])->name('profile.index');
Route::get('/profile/index2', [profileController::class, 'index2'])->name('profile.index2');
Route::get('/profile/create',[profileController::class, 'create'])->name('profile.create');
Route::get('/profiles/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/view/{id}', [profileController::class, 'view'])->name('profile.view');
Route::get('/profile/edit/{id}', [profileController::class, 'edit'])->name('profile.edit');
Route::post('/store',[profileController::class, 'store'])->name('profile.store');
Route::put('/profiles/{id}', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/delete/{id}', [profileController::class, 'destroy'])->name('profile.destroy');
// Route::post('/profile/update/{id}', [profileController::class, 'update'])->name('profile.update');
// Route::get('/profile/edit', [profileController::class, 'edit'])->name('profile.edit');
//Route::get('/profile/index2/{id}', [ProfileController::class, 'index2'])->name('profile.index2')
// Route::get('/create',[profileController::class, 'create'])->name('profile.create');;


Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/create', [ActivityController::class, 'create'])->middleware('can:admin')->name('activities.create');
Route::post('/activities', [ActivityController::class, 'store'])->middleware('can:admin')->name('activities.store');
Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->middleware('can:admin')->name('activities.edit');
Route::put('/activities/{activity}', [ActivityController::class, 'update'])->middleware('can:admin')->name('activities.update');
Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->middleware('can:admin')->name('activities.destroy');
Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
