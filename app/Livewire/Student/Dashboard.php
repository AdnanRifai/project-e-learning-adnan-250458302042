<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.master')]
class Dashboard extends Component
{
    public $courses;

    public function mount()
    {
        $this->courses = Course::latest()->get();
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
