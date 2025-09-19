<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\AnswerController;

// User Controllers
use App\Http\Controllers\User\QuizController as UserQuizController;
use App\Http\Controllers\User\LessonController as UserLessonController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\QuizResultController as UserQuizResultController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to user home
Route::redirect('/' , '/user')->name('root');

// Dashboard (default for logged-in users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');

        Route::resources([
            'categories' => CategoryController::class,
            'lessons'    => LessonController::class,
            'quizzes'    => QuizController::class,
            'questions'  => QuestionController::class,
            'answers'    => AnswerController::class,
        ]);

    Route::delete('questions/delete-all/{quiz}', [QuestionController::class, 'destroyAll'])
    ->name('questions.destroyAll');

    });

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])
            ->name('dashboard');

        // Redirect /user → /user/dashboard
        Route::get('/', function () {
            return redirect()->route('user.dashboard');
        });

        // Categories
        Route::resource('categories', UserCategoryController::class)->only(['index', 'show']);

        // Lessons
        Route::resource('lessons', UserLessonController::class)->only(['index', 'show']);

        // Quizzes
        Route::resource('quizzes', UserQuizController::class)->only(['index', 'show']);

        // Quiz submission
        Route::post('quizzes/{quiz}/submit', [UserQuizController::class, 'submit'])
            ->name('quizzes.submit');

        // Quiz results / history
        Route::get('history', [UserQuizResultController::class, 'historyCategories'])
            ->name('history.categories');

        Route::get('history/{category}', [UserQuizResultController::class, 'historyQuizzes'])
            ->name('history.quizzes');

        Route::get('quizzes/{quiz}/results/{attempt?}', [UserQuizResultController::class, 'show'])
            ->name('quizzes.results.show');

        Route::get('quizzes/{quiz}/results/{attempt}/summary', [UserQuizResultController::class, 'summary'])
            ->name('quizzes.results.summary');

        Route::post('lessons/{lesson}/complete', [UserLessonController::class, 'complete'])
            ->name('lessons.complete');

    });



require __DIR__.'/auth.php';
