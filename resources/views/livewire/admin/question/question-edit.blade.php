<div class="container mt-4">
    <h2>Edit Question</h2>

    <form wire:submit.prevent="update">
        <div class="mb-3">
            <label>Quiz</label>
            <select wire:model="quiz_id" class="form-control">
                <option value="">-- Select Quiz --</option>
                @foreach ($quizzes as $quiz)
                    <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <select wire:model="type" class="form-control">
                <option value="mcq">Multiple Choice</option>
                <option value="essay">Essay</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Question Text</label>
            <textarea wire:model="question_text" class="form-control" rows="4"></textarea>
            @error('question_text')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.question.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
