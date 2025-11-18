<?php

namespace App\Livewire\Admin\Option;

use Livewire\Component;
use App\Models\Question;

class OptionIndex extends Component
{
    public $question;

    public function mount(Question $question)
    {
        $this->question = $question;
    }

    public function delete($id)
    {
        $this->question->options()->findOrFail($id)->delete();

        session()->flash('success', 'Option berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.admin.option.option-index', [
            'options' => $this->question->options()->latest()->get(),
        ]);
    }
}
