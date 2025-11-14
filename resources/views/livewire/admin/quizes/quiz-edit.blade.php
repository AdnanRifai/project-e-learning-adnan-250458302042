<div class="container mt-4">
    <h2>Edit Quiz</h2>

    <form wire:submit.prevent="update">
        <div class="mb-3">
            <label>Lesson</label>
            <select wire:model="lesson_id" class="form-control">
                <option value="">-- Select Lesson --</option>
                @foreach($lessons as $lesson)
                    <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" wire:model="title" class="form-control">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Passing Score</label>
            <input type="number" wire:model="passing_score" class="form-control" min="0" max="100">
            @error('passing_score') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.quiz.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
