<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Question;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.master')]
class QuizResult extends Component
{
    public $quizId;
    public $userId;
    public $quiz;
    public $score = 0;
    public $total = 0;
    public $percentage = 0;
    public $passed = false;
    public $questions = [];
    public $userAnswers = [];
    public $showReview = false;

    public function mount($quizId, $userId = null)
    {
        $this->quizId = $quizId;
        $this->userId = $userId ?? Auth::id();

        // Load quiz data
        $this->quiz = Quiz::with('questions.options')->findOrFail($quizId);

        // Calculate score
        $this->calculateScore();

        // Load detailed answers for review
        $this->loadDetailedAnswers();
    }

    // =====================================================================================
    // CALCULATE SCORE
    // =====================================================================================
    public function calculateScore()
    {
        $this->total = $this->quiz->questions->count();
        $correctAnswers = 0;

        foreach ($this->quiz->questions as $question) {
            $correctOption = $question->options->firstWhere('is_correct', 1);

            $userAnswer = Answer::where('user_id', $this->userId)
                ->where('quiz_id', $this->quizId)
                ->where('question_id', $question->id)
                ->first();

            if ($correctOption && $userAnswer && $userAnswer->option_id == $correctOption->id) {
                $correctAnswers++;
            }
        }

        $this->score = $correctAnswers;
        $this->percentage = $this->total > 0 ? round(($correctAnswers / $this->total) * 100, 2) : 0;
        $this->passed = $this->percentage >= $this->quiz->passing_score;
    }

    // =====================================================================================
    // LOAD DETAILED ANSWERS FOR REVIEW
    // =====================================================================================
    public function loadDetailedAnswers()
    {
        $userAnswers = Answer::where('user_id', $this->userId)
            ->where('quiz_id', $this->quizId)
            ->get()
            ->keyBy('question_id');

        foreach ($this->quiz->questions as $index => $question) {
            $correctOption = $question->options->firstWhere('is_correct', 1);
            $userAnswer = $userAnswers->get($question->id);
            $selectedOption = $userAnswer ? $question->options->firstWhere('id', $userAnswer->option_id) : null;

            $this->questions[] = [
                'number' => $index + 1,
                'id' => $question->id,
                'question_text' => $question->question_text,
                'options' => $question->options->map(function($opt) use ($correctOption, $selectedOption) {
                    return [
                        'id' => $opt->id,
                        'option_text' => $opt->option_text,
                        'is_correct' => $opt->is_correct,
                        'is_selected' => $selectedOption && $selectedOption->id == $opt->id,
                        'is_correct_answer' => $correctOption && $correctOption->id == $opt->id,
                    ];
                })->toArray(),
                'is_correct' => $selectedOption && $correctOption && $selectedOption->id == $correctOption->id,
                'is_answered' => $userAnswer !== null,
            ];
        }
    }

    // =====================================================================================
    // TOGGLE REVIEW SECTION
    // =====================================================================================
    public function toggleReview()
    {
        $this->showReview = !$this->showReview;
    }

    // =====================================================================================
    // RETRY QUIZ (DELETE ALL ANSWERS)
    // =====================================================================================
    public function retryQuiz()
    {
        Answer::where('user_id', $this->userId)
            ->where('quiz_id', $this->quizId)
            ->delete();

        return redirect()->route('student.quiz.take', ['quizId' => $this->quizId]);
    }

    public function render()
    {
        return view('livewire.student.quiz-result');
    }
}
