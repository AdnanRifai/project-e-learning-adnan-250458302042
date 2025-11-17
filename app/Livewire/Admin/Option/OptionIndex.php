<?php

namespace App\Livewire\Admin\Option;

use Livewire\Component;
use App\Models\Option;
use App\Models\Question;

class OptionIndex extends Component
{
    public $options;
    public $questions;

    public $option_id;
    public $question_id;
    public $option_text;
    public $is_correct = false;

    public $isEdit = false;

    protected $rules = [
        'question_id' => 'required|exists:questions,id',
        'option_text' => 'required|string',
        'is_correct' => 'required|boolean'
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->options = Option::with('question')->latest()->get();
        $this->questions = Question::all();
    }

    public function resetForm()
    {
        $this->option_id = null;
        $this->question_id = null;
        $this->option_text = null;
        $this->is_correct = false;
        $this->isEdit = false;
    }

    public function create()
    {
        $this->resetForm();
    }

    public function store()
    {
        $this->validate();

        Option::create([
            'question_id' => $this->question_id,
            'option_text' => $this->option_text,
            'is_correct' => $this->is_correct
        ]);

        $this->resetForm();
        $this->loadData();

        session()->flash('success', 'Option berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $this->resetForm();

        $option = Option::findOrFail($id);

        $this->option_id = $option->id;
        $this->question_id = $option->question_id;
        $this->option_text = $option->option_text;
        $this->is_correct = $option->is_correct;

        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();

        Option::findOrFail($this->option_id)->update([
            'question_id' => $this->question_id,
            'option_text' => $this->option_text,
            'is_correct' => $this->is_correct
        ]);

        $this->resetForm();
        $this->loadData();

        session()->flash('success', 'Option berhasil diupdate!');
    }

    public function delete($id)
    {
        Option::findOrFail($id)->delete();
        $this->loadData();

        session()->flash('success', 'Option berhasil dihapus!');
    }
    public function render()
    {
        return view('livewire.admin.option.option-index');
    }
}
