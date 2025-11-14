<?php

namespace App\Livewire\Admin\Question;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\Question;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]

class QuestionEdit extends Component
{
    public $question_id, $quiz_id, $type, $question_text, $meta = [];
    public $quizzes;

    public function mount(Question $question)
    {
        $this->question_id = $question->id;
        $this->quiz_id = $question->quiz_id;
        $this->type = $question->type;
        $this->question_text = $question->question_text;
        $this->meta = $question->meta ?? [];
        $this->quizzes = Quiz::all();
    }

    public function update()
    {
        $this->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'type' => 'required|in:mcq,essay',
            'question_text' => 'required|string',
        ]);

        $question = Question::findOrFail($this->question_id);
        $question->update([
            'quiz_id' => $this->quiz_id,
            'type' => $this->type,
            'question_text' => $this->question_text,
            'meta' => $this->meta,
        ]);

        session()->flash('message', 'Question updated successfully.');
        return redirect()->route('admin.question.index');
    }

    public function render()
    {
        return view('livewire.admin.question.question-edit');
    }
}
