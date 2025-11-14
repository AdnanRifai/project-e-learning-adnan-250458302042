<?php

namespace App\Livewire\Admin\Course;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CourseIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // biar paginate-nya pakai Bootstrap

    public $courseId;
    public $title;
    public $description;
    public $level;
    public $price;
    public $published;

    public $isEdit = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'level' => 'nullable|in:beginner,intermediate,expert',
        'price' => 'nullable|numeric|min:0',
        'published' => 'boolean',
    ];

    // Reset input
    public function resetInput()
    {
        $this->courseId = null;
        $this->title = '';
        $this->description = '';
        $this->level = '';
        $this->price = '';
        $this->published = false;
        $this->isEdit = false;
    }

    // Create (tambah)
    public function store()
    {
        $this->validate();

        Course::create([
            'author_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'level' => $this->level,
            'price' => $this->price,
            'published' => $this->published,
        ]);

        session()->flash('success', 'Course berhasil ditambahkan!');
        $this->resetInput();
        $this->resetPage();
    }

    // Edit (ambil data)
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->courseId = $course->id;
        $this->title = $course->title;
        $this->description = $course->description;
        $this->level = $course->level;
        $this->price = $course->price;
        $this->published = $course->published;
        $this->isEdit = true;
    }

    // Update
    public function update()
    {
        $this->validate();

        $course = Course::findOrFail($this->courseId);
        $course->update([
            'title' => $this->title,
            'description' => $this->description,
            'level' => $this->level,
            'price' => $this->price,
            'published' => $this->published,
        ]);

        session()->flash('success', 'Course berhasil diupdate!');
        $this->resetInput();
        $this->resetPage();
    }

    // Delete
    public function destroy($id)
    {
        Course::findOrFail($id)->delete();
        session()->flash('success', 'Course berhasil dihapus!');
        $this->resetPage();
    }

    public function render()
    {
        $courses = Course::with('author')->latest()->paginate(10);
        return view('livewire.admin.course.course-index', compact('courses'));
    }
}
