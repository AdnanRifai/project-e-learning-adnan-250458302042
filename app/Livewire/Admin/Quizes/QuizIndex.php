<?php

namespace App\Livewire\Admin\Quizes;

use Livewire\Component;
use App\Models\Quiz;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class QuizIndex extends Component
{
    public $quizzes;

    public function mount()
    {
        $this->quizzes = Quiz::with('lesson')->latest()->get();
    }

    public function delete($id)
    {
        Quiz::findOrFail($id)->delete();
        $this->quizzes = Quiz::with('lesson')->latest()->get(); // refresh
        session()->flash('message', 'Quiz deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.quizes.quiz-index');
    }
}
