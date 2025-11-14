<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use Livewire\Attributes\Layout;

#[Layout("components.layouts.master")]
class HomePage extends Component
{
    public $courses;

    public function mount()
    {
        // Ambil semua data course dari database
        $this->courses = Course::all();
    }

    public function render()
    {
        return view('livewire.home-page', [
            'courses' => Course::all()
        ]);
    }

}
