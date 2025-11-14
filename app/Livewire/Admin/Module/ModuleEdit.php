<?php

namespace App\Livewire\Admin\Module;

use Livewire\Component;
use App\Models\Module;
use App\Models\Course;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ModuleEdit extends Component
{
    public $module;
    public $course_id, $title, $description, $order;
    public $courses;

    protected $rules = [
        'course_id' => 'required',
        'title' => 'required|string|min:3',
        'description' => 'nullable|string',
        'order' => 'required|integer|min:1',
    ];

    public function mount(Module $module)
    {
        $this->module = $module;
        $this->courses = Course::all();

        $this->course_id = $module->course_id;
        $this->title = $module->title;
        $this->description = $module->description;
        $this->order = $module->order;
    }

    public function update()
    {
        $this->validate();

        $this->module->update([
            'course_id' => $this->course_id,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
        ]);

        session()->flash('message', 'Module updated successfully!');
        return redirect()->route('admin.modules.index');
    }

    public function render()
    {
        return view('livewire.admin.module.module-edit');
    }
}
