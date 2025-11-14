<?php

namespace App\Livewire\Admin\Course;

use Livewire\Component;
use App\Models\Course;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CourseEdit extends Component
{
    public $course;
    public $title;
    public $description;
    public $level;
    public $price;
    public $published;

    public function mount($course)
    {
        $course = Course::findOrFail($course);
        $this->course = $course;
        $this->title = $course->title;
        $this->description = $course->description;
        $this->level = $course->level;
        $this->price = $course->price;
        $this->published = $course->published;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'nullable|in:beginner,intermediate,expert',
            'price' => 'nullable|numeric|min:0',
            'published' => 'boolean',
        ]);

        $this->course->update([
            'title' => $this->title,
            'description' => $this->description,
            'level' => $this->level,
            'price' => $this->price,
            'published' => $this->published,
        ]);

        session()->flash('success', 'Course berhasil diupdate!');
        return $this->redirectRoute('admin.courses.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.course.course-edit');
    }
}
