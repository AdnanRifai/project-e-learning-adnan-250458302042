<?php

namespace App\Livewire\Student;

use Livewire\Component;

class CourseSidebar extends Component
{
    public $course;
    public $modules;

    public function mount($course)
    {
        $this->course = $course;
        $this->modules = $course->modules()->with('lessons')->get();
    }

    public function render()
    {
        return view('livewire.student.course-sidebar', [
            'modules' => $this->modules
        ]);
    }
}
