<?php

namespace App\Livewire\Admin\Course;

use App\Models\Course;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CourseCreate extends Component
{
    public $title;
    public $description;
    public $level;
    public $price;
    public $published = false;

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|in:beginner,intermediate,expert',
            'price' => 'nullable|numeric|min:0',
        ]);

        Course::create([
            'author_id' => Auth::id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'level' => $this->level,
            'price' => $this->price,
            'published' => $this->published,
        ]);

        session()->flash('success', 'Course berhasil dibuat 🎉');
        return $this->redirectRoute('admin.courses.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.course.course-create');
    }
}
