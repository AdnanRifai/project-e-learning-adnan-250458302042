<?php

namespace App\Livewire\Admin\Quizes;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Quiz;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class QuizEdit extends Component
{
    public $quiz_id, $lesson_id, $title, $passing_score;
    public $lessons;

    public function mount(Quiz $quiz)
    {
        $this->quiz_id = $quiz->id;
        $this->lesson_id = $quiz->lesson_id;
        $this->title = $quiz->title;
        $this->passing_score = $quiz->passing_score;
        $this->lessons = Lesson::all();
    }

    public function update()
    {
        $this->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz = Quiz::findOrFail($this->quiz_id);
        $quiz->update([
            'lesson_id' => $this->lesson_id,
            'title' => $this->title,
            'passing_score' => $this->passing_score,
        ]);

        session()->flash('message', 'Quiz updated successfully.');
        return redirect()->route('admin.quiz.index');
    }

    public function render()
    {
        return view('livewire.admin.quizes.quiz-edit');
    }
}
