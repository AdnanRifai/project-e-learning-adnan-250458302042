<?php

namespace App\Livewire\Admin\Question;

use Livewire\Component;
use App\Models\Question;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class QuestionIndex extends Component
{
    public $questions;

    public function mount()
    {
        $this->questions = Question::with('quiz')->latest()->get();
    }

    public function delete($id)
    {
        Question::findOrFail($id)->delete();
        $this->questions = Question::with('quiz')->latest()->get();
        session()->flash('message', 'Question deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.question.question-index');
    }
}
