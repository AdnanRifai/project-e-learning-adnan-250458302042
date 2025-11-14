<?php

namespace App\Livewire\Admin\Lesson;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class LessonEdit extends Component
{
    public $lesson_id, $module_id, $title, $slug, $content_type, $content, $video_url, $duration, $free_preview, $position;
    public $modules;

    public function mount(Lesson $lesson)
    {
        $this->lesson_id = $lesson->id;
        $this->module_id = $lesson->module_id;
        $this->title = $lesson->title;
        $this->slug = $lesson->slug;
        $this->content_type = $lesson->content_type;
        $this->content = $lesson->content;
        $this->video_url = $lesson->video_url;
        $this->duration = $lesson->duration;
        $this->free_preview = $lesson->free_preview;
        $this->position = $lesson->position;

        $this->modules = Module::all();
    }

    public function update()
    {
        $this->validate([
            'module_id' => 'required',
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:video,pdf,text',
        ]);

        $lesson = Lesson::findOrFail($this->lesson_id);
        $lesson->update([
            'module_id' => $this->module_id,
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content_type' => $this->content_type,
            'content' => $this->content,
            'video_url' => $this->video_url,
            'duration' => $this->duration,
            'free_preview' => $this->free_preview,
            'position' => $this->position,
        ]);

        session()->flash('success', 'Lesson updated successfully!');
        return $this->redirectRoute('admin.lesson.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.lesson.lesson-edit');
    }
}

