<div class="container mt-4">
    <h2>Lessons</h2>
    <a wire:navigate href="{{ route('admin.lesson.create') }}" class="btn btn-primary mb-3">+ Add Lesson</a>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Module</th>
                <th>Title</th>
                <th>Content</th>
                <th>Duration</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->module->title ?? '-' }}</td>
                    <td>{{ $lesson->title }}</td>
                    <td>{{ $lesson->content }}</td>
                    <td>{{ $lesson->duration }}</td>
                    <td>
                        <a wire:navigate href="{{ route('admin.lesson.edit', $lesson->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button wire:click="delete({{ $lesson->id }})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
