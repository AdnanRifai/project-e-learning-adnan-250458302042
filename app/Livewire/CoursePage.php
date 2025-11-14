<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.master")]
class CoursePage extends Component
{
    public $courses;

    public function mount()
    {
        // Ambil semua data course dari database
        $this->courses = Course::all();
    }

    public function render()
    {
        return view('livewire.course-page', [
            'courses' => Course::all()
        ]);
    }
}
