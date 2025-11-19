<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Quiz as QuizModel;
use App\Models\Answer;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.master')]
class Quiz extends Component
{
    public $quizId;
    public $quiz;
    public $questions = [];
    public $answers = []; // Array untuk menyimpan semua jawaban [questionIndex => optionId]
    public $currentIndex = 0;
    public $courseId;

    public function mount($quizId)
    {
        $this->quizId = $quizId;
        $this->quiz = QuizModel::with('questions.options')->findOrFail($quizId);

        // Convert questions to simple array
        $this->questions = $this->quiz->questions->map(function($q){
            return [
                'id' => $q->id,
                'question_text' => $q->question_text,
                'type' => $q->type,
                'options' => $q->options->map(function($o){
                    return [
                        'id' => $o->id,
                        'option_text' => $o->option_text,
                        'is_correct' => $o->is_correct,
                    ];
                })->toArray()
            ];
        })->toArray();

        // Load semua jawaban yang sudah tersimpan
        $this->loadAllAnswers();
    }

    // =====================================================================================
    // LOAD SEMUA JAWABAN DARI DB
    // =====================================================================================
    public function loadAllAnswers()
    {
        $savedAnswers = Answer::where('user_id', Auth::id())
            ->where('quiz_id', $this->quizId)
            ->get()
            ->keyBy('question_id');

        // Map jawaban ke index array berdasarkan question_id
        foreach ($this->questions as $index => $question) {
            if (isset($savedAnswers[$question['id']])) {
                $this->answers[$index] = $savedAnswers[$question['id']]->option_id;
            } else {
                $this->answers[$index] = null;
            }
        }
    }

    // =====================================================================================
    // PILIH OPSI DAN SIMPAN LANGSUNG KE DB
    // =====================================================================================
    public function chooseOption($questionIndex, $optionId)
    {
        // Update state lokal
        $this->answers[$questionIndex] = $optionId;

        // Simpan langsung ke database
        $questionId = $this->questions[$questionIndex]['id'];

        Answer::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'quiz_id' => $this->quizId,
                'question_id' => $questionId,
            ],
            [
                'option_id' => $optionId
            ]
        );

        // Optional: Tampilkan notifikasi sukses (bisa dihapus jika tidak perlu)
        $this->dispatch('answer-saved');
    }

    // =====================================================================================
    // GO TO SPECIFIC QUESTION
    // =====================================================================================
    public function goToQuestion($index)
    {
        if ($index >= 0 && $index < count($this->questions)) {
            $this->currentIndex = $index;
        }
    }

    // =====================================================================================
    // NEXT QUESTION
    // =====================================================================================
    public function next()
    {
        if ($this->currentIndex < count($this->questions) - 1) {
            $this->currentIndex++;
        }
    }

    // =====================================================================================
    // PREVIOUS QUESTION
    // =====================================================================================
    public function prev()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    // =====================================================================================
    // SUBMIT QUIZ (MENGHITUNG NILAI)
    // =====================================================================================
    public function submitQuiz()
    {
        $userId = Auth::id();
        $total = count($this->questions);
        $score = 0;

        foreach ($this->questions as $q) {
            $correctOption = collect($q['options'])->firstWhere('is_correct', 1);

            $userAnswer = Answer::where('user_id', $userId)
                ->where('quiz_id', $this->quizId)
                ->where('question_id', $q['id'])
                ->first();

            if ($correctOption && $userAnswer && $userAnswer->option_id == $correctOption['id']) {
                $score++;
            }
        }

        $percentage = ($score / $total) * 100;

        session()->flash('quiz_result', [
            'score' => $score,
            'total' => $total,
            'percentage' => round($percentage, 2),
            'passed' => $percentage >= $this->quiz->passing_score
        ]);

        return redirect()->route('student.quiz.result', [
            'quizId' => $this->quizId,
            'userId' => $userId
        ]);
    }

    public function render()
    {
        return view('livewire.student.quiz');
    }
}
