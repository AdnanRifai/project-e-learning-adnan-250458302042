<?php

namespace App\Livewire\Admin\Question;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\Question;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class QuestionCreate extends Component
{
    public $quiz_id, $type = 'mcq', $question_text, $meta = [];
    public $quizzes;

    public function mount()
    {
        $this->quizzes = Quiz::all();
    }

    public function save()
    {
        $this->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'type' => 'required|in:mcq,essay',
            'question_text' => 'required|string',
        ]);

        Question::create([
            'quiz_id' => $this->quiz_id,
            'type' => $this->type,
            'question_text' => $this->question_text,
            'meta' => $this->meta,
        ]);

        session()->flash('message', 'Question created successfully.');
        return redirect()->route('admin.question.index');
    }

    public function render()
    {
        return view('livewire.admin.question.question-create');
    }
}
