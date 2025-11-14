<?php

namespace App\Livewire\Admin\Module;

use Livewire\Component;
use App\Models\Module;
use App\Models\Course;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ModuleCreate extends Component
{
    public $course_id, $title, $description, $order;
    public $courses;

    protected $rules = [
        'course_id' => 'required',
        'title' => 'required|string|min:3',
        'description' => 'nullable|string',
        'order' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->courses = Course::all();
    }

    public function save()
    {
        $this->validate();
        Module::create([
            'course_id' => $this->course_id,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
        ]);

        session()->flash('message', 'Module added successfully!');
        return redirect()->route('admin.modules.index');
    }

    public function render()
    {
        return view('livewire.admin.module.module-create');
    }
}
