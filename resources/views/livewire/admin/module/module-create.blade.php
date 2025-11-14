<div class="container mt-4">
    <h2>Add New Module</h2>

    <form wire:submit.prevent="save">
        <div class="mb-3">
            <label>Course</label>
            <select wire:model="course_id" class="form-control">
                <option value="">-- Select Course --</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
            @error('course_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input wire:model="title" class="form-control">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea wire:model="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Order</label>
            <input type="number" wire:model="order" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
