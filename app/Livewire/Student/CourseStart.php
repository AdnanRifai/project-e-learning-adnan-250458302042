<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CourseStart extends Component
{
    public $courseSlug;
    public $course;
    public $enrollment;
    public $currentLesson;
    public $modules;
    public $completedLessons = [];
    public $sidebarOpen = true;

    protected $queryString = ['lesson'];
    public $lesson;

    public function mount($slug)
    {
        $this->courseSlug = $slug;

        // Load course dengan relasi
        $this->course = Course::where('slug', $slug)
            ->with(['modules.lessons' => function($query) {
                $query->orderBy('position');
            }])
            ->firstOrFail();

        // Check enrollment
        $this->enrollment = Enrollment::firstOrCreate([
            'user_id' => Auth::id(),
            'course_id' => $this->course->id,
        ], [
            'enrolled_at' => now(),
            'progress' => 0,
        ]);

        // Load modules
        $this->modules = $this->course->modules()
            ->with('lessons')
            ->orderBy('position')
            ->get();

        // Load completed lessons dari session atau database
        $this->loadCompletedLessons();

        // Set current lesson
        if ($this->lesson) {
            $this->loadLesson($this->lesson);
        } else {
            // Load first lesson jika tidak ada lesson yang dipilih
            $this->loadFirstLesson();
        }
    }

    public function loadLesson($lessonId)
    {
        $this->currentLesson = Lesson::with('module')->findOrFail($lessonId);
        $this->lesson = $lessonId;

        // Update query string
        $this->dispatch('lessonChanged', $this->currentLesson->id);
    }

    public function loadFirstLesson()
    {
        $firstModule = $this->modules->first();
        if ($firstModule && $firstModule->lessons->count() > 0) {
            $this->currentLesson = $firstModule->lessons->first();
            $this->lesson = $this->currentLesson->id;
        }
    }

    public function markComplete()
    {
        if (!$this->currentLesson) {
            return;
        }

        // Tambahkan ke completed lessons
        if (!in_array($this->currentLesson->id, $this->completedLessons)) {
            $this->completedLessons[] = $this->currentLesson->id;

            // Simpan ke session atau database
            session()->put('completed_lessons_' . $this->course->id, $this->completedLessons);

            // Update progress
            $this->updateProgress();

            $this->dispatch('lesson-completed', $this->currentLesson->id);
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Lesson marked as complete!'
            ]);
        }
    }

    public function nextLesson()
    {
        if (!$this->currentLesson) {
            return;
        }

        $currentModule = $this->currentLesson->module;
        $lessons = $currentModule->lessons->sortBy('position');

        $currentIndex = $lessons->search(function ($lesson) {
            return $lesson->id === $this->currentLesson->id;
        });

        // Check if there's a next lesson in current module
        if ($currentIndex !== false && $currentIndex < $lessons->count() - 1) {
            $nextLesson = $lessons->values()[$currentIndex + 1];
            $this->loadLesson($nextLesson->id);
        } else {
            // Move to next module
            $nextModule = $this->modules->where('position', '>', $currentModule->position)
                ->sortBy('position')
                ->first();

            if ($nextModule && $nextModule->lessons->count() > 0) {
                $nextLesson = $nextModule->lessons->sortBy('position')->first();
                $this->loadLesson($nextLesson->id);
            } else {
                $this->dispatch('notify', [
                    'type' => 'info',
                    'message' => 'You have reached the end of the course!'
                ]);
            }
        }
    }

    public function previousLesson()
    {
        if (!$this->currentLesson) {
            return;
        }

        $currentModule = $this->currentLesson->module;
        $lessons = $currentModule->lessons->sortBy('position');

        $currentIndex = $lessons->search(function ($lesson) {
            return $lesson->id === $this->currentLesson->id;
        });

        // Check if there's a previous lesson in current module
        if ($currentIndex !== false && $currentIndex > 0) {
            $prevLesson = $lessons->values()[$currentIndex - 1];
            $this->loadLesson($prevLesson->id);
        } else {
            // Move to previous module
            $prevModule = $this->modules->where('position', '<', $currentModule->position)
                ->sortByDesc('position')
                ->first();

            if ($prevModule && $prevModule->lessons->count() > 0) {
                $prevLesson = $prevModule->lessons->sortByDesc('position')->first();
                $this->loadLesson($prevLesson->id);
            } else {
                $this->dispatch('notify', [
                    'type' => 'info',
                    'message' => 'You are at the first lesson!'
                ]);
            }
        }
    }

    public function toggleSidebar()
    {
        $this->sidebarOpen = !$this->sidebarOpen;
    }

    public function isLessonCompleted($lessonId)
    {
        return in_array($lessonId, $this->completedLessons);
    }

    public function isCurrentLesson($lessonId)
    {
        return $this->currentLesson && $this->currentLesson->id === $lessonId;
    }

    private function loadCompletedLessons()
    {
        // Load dari session (bisa diganti dengan database)
        $this->completedLessons = session()->get('completed_lessons_' . $this->course->id, []);
    }

    private function updateProgress()
    {
        $totalLessons = $this->modules->sum(function ($module) {
            return $module->lessons->count();
        });

        if ($totalLessons > 0) {
            $progress = (count($this->completedLessons) / $totalLessons) * 100;

            $this->enrollment->update([
                'progress' => round($progress, 2)
            ]);

            // Check if completed
            if ($progress >= 100) {
                $this->enrollment->update([
                    'completed_at' => now()
                ]);
            }
        }
    }

    public function getTotalLessonsProperty()
    {
        return $this->modules->sum(function ($module) {
            return $module->lessons->count();
        });
    }

    public function getTotalDurationProperty()
    {
        return $this->modules->sum(function ($module) {
            return $module->lessons->sum('duration');
        });
    }

    public function render()
    {
        return view('livewire.course-start');
    }
}
