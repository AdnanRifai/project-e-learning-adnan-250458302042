<div class="section">
    <div class="section-header">
        <h1>Buat Course Baru</h1>
        <div class="section-header-breadcrumb ms-auto">
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="section-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form wire:submit.prevent="save">
                    <div class="form-group mb-3">
                        <label>Judul Course</label>
                        <input type="text" wire:model="title" class="form-control">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <textarea wire:model="description" class="form-control" rows="4"></textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Tingkat (Level)</label>
                        <select wire:model="level" class="form-control">
                            <option value="">-- Pilih Level --</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="expert">Expert</option>
                        </select>
                        @error('level')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Harga</label>
                        <input type="number" wire:model="price" class="form-control">
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" wire:model="published" class="form-check-input" id="published">
                        <label for="published" class="form-check-label">Terbitkan Course</label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Course
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
