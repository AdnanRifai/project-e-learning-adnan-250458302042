<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Modules List</h2>
        <a wire:navigate href="{{ route('admin.modules.create') }}" class="btn btn-primary">+ Add Module</a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Course</th>
                <th>Title</th>
                <th>Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modules as $module)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $module->course->title ?? '-' }}</td>
                    <td>{{ $module->title }}</td>
                    <td>{{ $module->order }}</td>
                    <td>
                        <a wire:navigate href="{{ route('admin.modules.edit', $module->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button wire:click="delete({{ $module->id }})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
