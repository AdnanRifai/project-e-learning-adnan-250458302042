<?php

namespace App\Livewire\Admin\Question;

use Livewire\Component;
use App\Models\Question;
use App\Models\Option;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class QuestionShow extends Component
{
    public $question;

    // form option
    public $option_text;
    public $is_correct = false;

    public function mount(Question $question)
    {
        $this->question = $question;
    }

    public function addOption()
    {
        $this->validate([
            'option_text' => 'required',
            'is_correct' => 'boolean'
        ]);

        $this->question->options()->create([
            'option_text' => $this->option_text,
            'is_correct' => $this->is_correct,
        ]);

        // reset form
        $this->option_text = '';
        $this->is_correct = false;

        session()->flash('success', 'Option berhasil ditambahkan!');
    }

    public function deleteOption($id)
    {
        Option::findOrFail($id)->delete();

        session()->flash('success', 'Option berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.admin.question.question-show', [
            'options' => $this->question->options()->get()
        ]);
    }
}
