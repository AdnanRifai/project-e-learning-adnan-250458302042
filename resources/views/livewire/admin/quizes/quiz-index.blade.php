<div class="container mt-4">
    <h2>Quiz List</h2>
    <a href="{{ route('admin.quiz.create') }}" class="btn btn-primary mb-3">+ Add Quiz</a>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Lesson</th>
                <th>Title</th>
                <th>Passing Score</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quizzes as $quiz)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $quiz->lesson->title ?? '-' }}</td>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->passing_score }}</td>
                    <td>
                        <a href="{{ route('admin.quiz.edit', $quiz->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button wire:click="delete({{ $quiz->id }})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
