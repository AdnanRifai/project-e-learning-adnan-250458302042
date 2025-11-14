<?php

namespace App\Livewire\Student;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Course;

#[Layout('components.layouts.master')]
class CourseDetail extends Component
{
    public $course;

    // component
    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function render()
    {
        return view('livewire.student.course-detail');
    }
}
