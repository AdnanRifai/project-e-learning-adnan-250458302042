<section class="section">
    <div class="section-header">
        <h1>Daftar Course</h1>
        <div class="section-header-button ms-auto">
            <a wire:navigate href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Course
            </a>
        </div>
    </div>

    <div class="section-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4>List Course</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Author</th>
                                <th>Level</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $index => $course)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $course->title }}</td>
                                    <td>{{ $course->author->name ?? '-' }}</td>
                                    <td>{{ ucfirst($course->level) ?? '-' }}</td>
                                    <td>
                                        @if ($course->price)
                                            Rp {{ number_format($course->price, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $course->published ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $course->published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a wire:navigate href="{{ route('admin.courses.edit', $course->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="destroy({{ $course->id }})"
                                            onclick="return confirm('Yakin ingin hapus course ini?')"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada course</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
