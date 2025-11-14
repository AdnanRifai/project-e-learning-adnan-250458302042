<section class="section">
    <div class="section-header">
        <h1>Edit Course</h1>
    </div>

    <div class="section-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4>Form Edit Course</h4>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="update">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" wire:model="title" class="form-control">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea wire:model="description" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select wire:model="level" class="form-control">
                            <option value="">-- Pilih Level --</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="expert">Expert</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" wire:model="price" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select wire:model="published" class="form-control">
                            <option value="0">Draft</option>
                            <option value="1">Published</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a wire:navigate href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</section>
