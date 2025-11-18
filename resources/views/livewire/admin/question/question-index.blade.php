<div class="container mt-4">
    <h2>Question List</h2>
    <a href="{{ route('admin.question.create') }}" class="btn btn-primary mb-3">+ Add Question</a>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Quiz</th>
                <th>Type</th>
                <th>Question Text</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $question->quiz->title ?? '-' }}</td>
                    <td>{{ strtoupper($question->type) }}</td>
                    <td>{{ Str::limit($question->question_text, 80) }}</td>
                    <td>
                        <a href="{{ route('admin.question.edit', $question->id) }}"
                            class="btn btn-warning btn-sm">Edit</a>
                        <button wire:click="delete({{ $question->id }})" class="btn btn-danger btn-sm">Delete</button>
                        <a href="{{ route('admin.question.show', $question->id) }}"
                            class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
