<?php

namespace App\Livewire\Admin\Lesson;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Module;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class LessonIndex extends Component
{
    public $lessons;

    public function mount()
    {
        $this->lessons = Lesson::with('module')->latest()->get();
    }

    public function delete($id)
    {
        Lesson::findOrFail($id)->delete();
        session()->flash('success', 'Lesson deleted successfully!');
        $this->lessons = Lesson::with('module')->latest()->get();
    }

    public function render()
    {
        return view('livewire.admin.lesson.lesson-index');
    }
}

