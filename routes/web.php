<?php

use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Course\CourseIndex;
use App\Livewire\Admin\Course\CourseCreate;
use App\Livewire\Admin\Course\CourseEdit;
use App\Livewire\Admin\Module\ModuleIndex;
use App\Livewire\Admin\Lesson\LessonIndex;
use App\Livewire\Admin\Question\QuestionIndex;
use App\Livewire\Admin\Comment\CommentIndex;
use App\Livewire\Admin\Lesson\LessonCreate;
use App\Livewire\Admin\Lesson\LessonEdit;
use App\Livewire\Admin\Module\ModuleCreate;
use App\Livewire\Admin\Module\ModuleEdit;
use App\Livewire\Admin\Module\ModuleShow;
use App\Livewire\Admin\Statistics\StatisticsIndex;
use App\Livewire\Admin\Profile\ProfileEdit;
use App\Livewire\Admin\Question\QuestionCreate;
use App\Livewire\Admin\Question\QuestionEdit;
use App\Livewire\Admin\Quizes\QuizCreate;
use App\Livewire\Admin\Quizes\QuizEdit;
use App\Livewire\Admin\Quizes\QuizIndex;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\CoursePage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\Student\CourseDetail;
use App\Livewire\Student\Dashboard;

Route::get('/', HomePage::class)->name('home');
Route::get('/courses', CoursePage::class)->name('course');

// AUTH
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

// LOGOUT
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})
    ->name('logout')
    ->middleware('auth');

// ======================
// ADMIN ROUTES
// ======================
Route::middleware(['auth', 'role.redirect', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

        // Courses
        Route::get('/courses', CourseIndex::class)->name('courses.index');
        Route::get('/courses/create', CourseCreate::class)->name('courses.create');
        Route::get('/courses/{course}/edit', CourseEdit::class)->name('courses.edit');

        // Modules
        Route::get('/modules', ModuleIndex::class)->name('modules.index');
        Route::get('/modules/create', ModuleCreate::class)->name('modules.create');
        Route::get('/modules/{module}/edit', ModuleEdit::class)->name('modules.edit');
        Route::get('/modules/{module}', ModuleShow::class)->name('modules.show');

        // Lessons
        Route::get('/lessons', LessonIndex::class)->name('lesson.index');
        Route::get('/lessons/create', LessonCreate::class)->name('lesson.create');
        Route::get('/lessons/{lesson}/edit', LessonEdit::class)->name('lesson.edit');

        Route::get('/quizzes', QuizIndex::class)->name('quiz.index');
        Route::get('/quizzes/create', QuizCreate::class)->name('quiz.create');
        Route::get('/quizzes/{quiz}/edit', QuizEdit::class)->name('quiz.edit');

        // Questions
        Route::get('/questions', QuestionIndex::class)->name('question.index');
        Route::get('/questions/create', QuestionCreate::class)->name('question.create');
        Route::get('/questions/{question}/edit', QuestionEdit::class)->name('question.edit');

        // Comments
        Route::get('/comments', CommentIndex::class)->name('comments.index');

        // Statistics
        Route::get('/statistics', StatisticsIndex::class)->name('statistics.index');

        // Profile
        Route::get('/profile', ProfileEdit::class)->name('profile.edit');
    });

// ======================
// STUDENT ROUTES
// ======================
use App\Livewire\Student\CourseStart; // jangan lupa import
use App\Livewire\Student\Quiz;

Route::middleware(['auth', 'role.redirect', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/course/{course}', CourseDetail::class)->name('course.detail');

        // Route untuk mulai belajar
        Route::get('/course/{course}/start', CourseStart::class)->name('course.start');

        // Start Quiz
        Route::get('/quiz/{quizId}/start', Quiz::class)->name('quiz.start');

        // Quiz Result
        Route::get('/quiz/{quizId}/result', function ($quizId) {
            return view('student.quiz-result', compact('quizId'));
        })->name('quiz.result');
    });
