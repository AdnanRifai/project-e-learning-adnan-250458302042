<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Quiz as QuizModel;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.master')]
class Quiz extends Component
{
    public $quizId;
    public $quiz;
    public $questions = [];
    public $currentIndex = 0;
    public $answers = [];
    public $courseId;

    public function mount($quizId)
    {
        $this->quizId = $quizId;
        $this->quiz = QuizModel::with('questions.options')->findOrFail($quizId);

        // Convert to array untuk digunakan di view
        $this->questions = $this->quiz->questions->map(function($question) {
            return [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'type' => $question->type,
                'options' => $question->options->map(function($option) {
                    return [
                        'id' => $option->id,
                        'option_text' => $option->option_text,
                        'is_correct' => $option->is_correct
                    ];
                })->toArray()
            ];
        })->toArray();

        // Initialize answers array
        foreach ($this->questions as $idx => $q) {
            $this->answers[$idx] = null;
        }
    }

    public function goToQuestion($index)
    {
        if ($index >= 0 && $index < count($this->questions)) {
            $this->currentIndex = $index;
        }
    }

    public function next()
    {
        if ($this->currentIndex < count($this->questions) - 1) {
            $this->currentIndex++;
        }
    }

    public function prev()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    public function chooseOption($questionIndex, $optionId)
    {
        $this->answers[$questionIndex] = $optionId;
    }

    public function submitQuiz()
    {
        // Hitung skor
        $score = 0;
        $totalQuestions = count($this->questions);

        foreach ($this->questions as $idx => $question) {
            // Cari jawaban yang benar
            $correctOption = collect($question['options'])->firstWhere('is_correct', 1);

            // Cek apakah user jawab benar
            if ($correctOption && $correctOption['id'] == ($this->answers[$idx] ?? null)) {
                $score++;
            }
        }

        // Hitung persentase
        $percentage = ($score / $totalQuestions) * 100;

        // Simpan hasil ke session
        session()->flash('quiz_result', [
            'score' => $score,
            'total' => $totalQuestions,
            'percentage' => round($percentage, 2),
            'passed' => $percentage >= $this->quiz->passing_score
        ]);

        // Redirect ke halaman hasil
        return redirect()->route('student.quiz.result', $this->quizId);
    }

    public function hydrate()
    {
        $this->questions ??= [];
        $this->answers ??= [];
    }


    public function render()
    {
        return view('livewire.student.quiz');
    }
}
