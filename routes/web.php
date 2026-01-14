<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Dashboard\DashboardController;


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

// Quiz Management Routes (Admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{quiz}/toggle-status', [QuizController::class, 'toggleStatus'])->name('quizzes.toggleStatus');

    // Student Quiz Routes
    Route::get('/student/quizzes', [QuizController::class, 'availableQuizzes'])->name('student.quizzes');
    Route::get('/student/quizzes/{quiz}/start', [QuizController::class, 'startQuiz'])->name('quizzes.start');
    Route::post('/student/quizzes/{quiz}/submit', [QuizController::class, 'submitQuiz'])->name('quizzes.submit');
    Route::get('/student/quizzes/{quiz}/results', [QuizController::class, 'viewResults'])->name('quizzes.results');


    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Optional stricter role routes
    Route::get('/dashboard/parent',  [DashboardController::class, 'index'])->middleware('role:PARENT');
    Route::get('/dashboard/teacher', [DashboardController::class, 'index'])->middleware('role:TEACHER');
    Route::get('/dashboard/admin',   [DashboardController::class, 'index'])->middleware('role:KAFA_ADMIN,MUIP_ADMIN');

    // Existing Profile routes
    Route::get('/profiles', [profileController::class, 'index'])->name('profile.index');
    Route::get('/profiles/create', [profileController::class, 'create'])->name('profile.create');
    Route::post('/profiles', [profileController::class, 'store'])->name('profile.store');
    Route::get('/profiles/{id}', [profileController::class, 'show'])->name('profile.view');
    Route::get('/profiles/{id}/edit', [profileController::class, 'edit'])->name('profile.edit');
    Route::put('/profiles/{id}', [profileController::class, 'update'])->name('profile.update');
    Route::delete('/profiles/{id}', [profileController::class, 'destroy'])->name('profile.destroy');
});
