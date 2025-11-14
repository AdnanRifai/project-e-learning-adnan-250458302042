<div class="container mt-4">
    <h2>{{ $lesson_id ? 'Edit Lesson' : 'Add New Lesson' }}</h2>

    <form wire:submit.prevent="update" id="lessonForm">
        <div class="mb-3">
            <label>Module</label>
            <select wire:model="module_id" class="form-control">
                <option value="">-- Select Module --</option>
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->title }}</option>
                @endforeach
            </select>
            @error('module_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" wire:model="title" class="form-control">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4" wire:ignore>
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Konten
            </label>
            <textarea
                id="editor"
                wire:model="content"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                rows="10"
            ></textarea>
            @error('content')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>Duration (minutes)</label>
            <input type="number" wire:model="duration" class="form-control">
            @error('duration')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" wire:model="free_preview" class="form-check-input" id="freePreview">
            <label class="form-check-label" for="freePreview">Free Preview</label>
        </div>

        <div class="mb-3">
            <label>Position</label>
            <input type="number" wire:model="position" class="form-control">
        </div>

        <button class="btn btn-primary" type="submit">
            Save
        </button>
    </form>
</div>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ]
            })
            .then(editor => {
                // Sinkronisasi dengan Livewire
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                });

                // Update editor ketika Livewire mereset form
                Livewire.on('contentReset', () => {
                    editor.setData('');
                });
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endpush
