<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.master')]
class CourseDetail extends Component
{
    public $course;

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function belajar()
    {
        $user = Auth::user();

        // cek sudah daftar atau belum
        $enroll = Enrollment::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $this->course->id
        ],[
            'enrolled_at' => now(),
            'progress' => 0
        ]);

        // Redirect ke halaman belajar
        return redirect()->route('course.start', $this->course->slug);
    }

    public function render()
    {
        return view('livewire.student.course-detail');
    }
}
