<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Models\Lesson;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.lessons')]
class CourseStart extends Component
{
    public $course;
    public $modules;
    public $selectedLesson;
    public $questions = [];
    public $currentIndex = 0; // Add this property
    public $answers = []; // Add this property

    // Tambahkan property untuk navigation state
    public $hasPreviousLesson = false;
    public $hasNextLesson = false;
    public $progressPercentage = 0;

    public function mount(Course $course)
    {
        // Load lengkap: course + modules + lessons
        $this->course = $course->load([
            'modules.lessons' => function ($q) {
                $q->orderBy('position');
            },
        ]);

        // Modules udah ada di $course, tinggal sort
        $this->modules = $this->course->modules->sortBy('position');

        // Default: lesson pertama dari modul pertama
        $this->selectedLesson = $this->modules->flatMap->lessons->filter(fn($lesson) => $lesson->quiz)->first();

        // Load questions if lesson has quiz
        $this->loadQuestions();

        // Update navigation state setelah set selectedLesson
        $this->updateNavigationState();
    }

    public function selectLesson($lessonId)
    {
        $lesson = Lesson::with('quiz.questions')->find($lessonId);

        if (!$lesson || $lesson->module->course_id !== $this->course->id) {
            return;
        }

        $this->selectedLesson = $lesson;
        $this->loadQuestions();
        $this->resetQuizState(); // Reset quiz state when changing lessons
        $this->updateNavigationState();

        $this->dispatch('lessonSelected');
    }

    // Add method to load questions
    private function loadQuestions()
    {
        if ($this->selectedLesson && $this->selectedLesson->quiz) {
            $this->questions = $this->selectedLesson->quiz->questions ?? [];
        } else {
            $this->questions = [];
        }
    }

    // Add method to reset quiz state
    private function resetQuizState()
    {
        $this->currentIndex = 0;
        $this->answers = [];
    }

    // Add method to navigate between questions
    public function goToQuestion($index)
    {
        if ($index >= 0 && $index < count($this->questions)) {
            $this->currentIndex = $index;
        }
    }

    // Add method to go to next question
    public function nextQuestion()
    {
        if ($this->currentIndex < count($this->questions) - 1) {
            $this->currentIndex++;
        }
    }

    // Add method to go to previous question
    public function previousQuestion()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    // Add method to save answer
    public function saveAnswer($questionIndex, $answer)
    {
        $this->answers[$questionIndex] = $answer;
    }

    public function previousLesson()
    {
        $allLessons = $this->getAllLessons();
        $currentIndex = $allLessons->search(function ($lesson) {
            return $lesson->id === $this->selectedLesson->id;
        });

        if ($currentIndex > 0) {
            $previousLesson = $allLessons[$currentIndex - 1];
            $this->selectLesson($previousLesson->id);
        }
    }

    public function nextLesson()
    {
        $allLessons = $this->getAllLessons();
        $currentIndex = $allLessons->search(function ($lesson) {
            return $lesson->id === $this->selectedLesson->id;
        });

        if ($currentIndex < $allLessons->count() - 1) {
            $nextLesson = $allLessons[$currentIndex + 1];
            $this->selectLesson($nextLesson->id);
        }
    }

    public function completeCourse()
    {
        // Logic untuk menyelesaikan kursus
        // Contoh: update progress user, redirect, dll.
        return redirect()->route('courses.show', $this->course->id)->with('success', 'Kursus berhasil diselesaikan!');
    }

    // Method untuk update navigation state
    private function updateNavigationState()
    {
        if (!$this->selectedLesson) {
            $this->hasPreviousLesson = false;
            $this->hasNextLesson = false;
            return;
        }

        $allLessons = $this->getAllLessons();
        $currentIndex = $allLessons->search(function ($lesson) {
            return $lesson->id === $this->selectedLesson->id;
        });

        $this->hasPreviousLesson = $currentIndex > 0;
        $this->hasNextLesson = $currentIndex < $allLessons->count() - 1;

        // Update progress percentage
        $this->updateProgressPercentage();
    }

    // Method untuk update progress
    private function updateProgressPercentage()
    {
        $totalLessons = $this->getAllLessons()->count();

        if ($totalLessons === 0) {
            $this->progressPercentage = 0;
            return;
        }

        // Contoh sederhana: progress berdasarkan lesson yang sedang dilihat
        $allLessons = $this->getAllLessons();
        $currentIndex = $allLessons->search(function ($lesson) {
            return $lesson->id === $this->selectedLesson->id;
        });

        // Progress = (index lesson saat ini + 1) / total lessons * 100
        $this->progressPercentage = round((($currentIndex + 1) / $totalLessons) * 100);
    }

    private function getAllLessons()
    {
        return $this->modules->flatMap(function ($module) {
            return $module->lessons;
        });
    }

    public function startQuiz($quizId)
    {
        if (!$quizId) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Quiz not available']);
            return;
        }

        return redirect()->route('student.quiz.start', $quizId);
    }

    public function render()
    {
        return view('livewire.student.course-start');
    }
}
