<div class="container mt-4">
    <h2>Edit Module</h2>

    <form wire:submit.prevent="update">
        <div class="mb-3">
            <label>Course</label>
            <select wire:model="course_id" class="form-control">
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input wire:model="title" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea wire:model="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Order</label>
            <input type="number" wire:model="order" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a wire:navigate href="{{ route('admin.modules.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
