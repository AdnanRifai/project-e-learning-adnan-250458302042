<?php

namespace App\Livewire\Admin\Lesson;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Module;
use Livewire\Attributes\Layout;

use function Illuminate\Log\log;

#[Layout('components.layouts.app')]
class LessonCreate extends Component
{
    public $lesson_id;
    public $module_id;
    public $title;
    public $content;
    public $duration;
    public $free_preview = false;
    public $position = 0;

    public function mount($lesson_id = null)
    {
        if ($lesson_id) {
            $lesson = Lesson::findOrFail($lesson_id);
            $this->lesson_id = $lesson->id;
            $this->module_id = $lesson->module_id;
            $this->title = $lesson->title;
            $this->content = $lesson->content;
            $this->duration = $lesson->duration;
            $this->free_preview = $lesson->free_preview;
            $this->position = $lesson->position;
        }
    }

    public function save()
    {
        $this->dispatch('sync-editor');

        $this->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'duration' => 'nullable|integer|min:0',
            'position' => 'nullable|integer|min:0',
        ]);

        Lesson::create(
            [
                'id' => $this->lesson_id,
                'module_id' => $this->module_id,
                'title' => $this->title,
                'content' => $this->content,
                'duration' => $this->duration,
                'free_preview' => $this->free_preview,
                'position' => $this->position,
            ],
        );

        session()->flash('success', $this->lesson_id ? 'Lesson updated!' : 'Lesson created!');
        return $this->redirectRoute('admin.lesson.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.lesson.lesson-create', [
            'modules' => Module::all(),
        ]);
    }
}
