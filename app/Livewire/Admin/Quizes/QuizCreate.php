<?php

namespace App\Livewire\Admin\Quizes;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Quiz;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class QuizCreate extends Component
{
    public $lesson_id, $title, $passing_score;
    public $lessons;

    public function mount()
    {
        $this->lessons = Lesson::all();
    }

    public function save()
    {
        $this->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        Quiz::create([
            'lesson_id' => $this->lesson_id,
            'title' => $this->title,
            'passing_score' => $this->passing_score,
        ]);

        session()->flash('message', 'Quiz created successfully.');
        return redirect()->route('admin.quiz.index');
    }

    public function render()
    {
        return view('livewire.admin.quizes.quiz-create');
    }
}
