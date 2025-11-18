<!-- Main Content -->
<section class="section">
    <div class="section-header">
        <h1>Detail Pertanyaan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pertanyaan</a></div>
            <div class="breadcrumb-item">Detail Pertanyaan</div>
        </div>
    </div>

    <div class="section-body">
        <!-- Question Detail Card -->
        <div class="card">
            <div class="card-header">
                <h4>Detail Pertanyaan</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Pertanyaan:</label>
                    <p class="form-control-static">{{ $question->question_text }}</p>
                </div>
                <div class="form-group">
                    <label>Tipe:</label>
                    <p class="form-control-static">
                        <span class="badge badge-primary">{{ $question->type }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Add Option Form -->
        <div class="card">
            <div class="card-header">
                <h4>Tambah Opsi</h4>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="addOption">
                    <div class="form-group">
                        <label for="option_text">Teks Opsi</label>
                        <input type="text" id="option_text" wire:model="option_text"
                            class="form-control @error('option_text') is-invalid @enderror">
                        @error('option_text')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_correct" wire:model="is_correct">
                            <label class="custom-control-label" for="is_correct">
                                Opsi Benar?
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus"></i> Tambah Opsi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Options List -->
        <div class="card">
            <div class="card-header">
                <h4>Daftar Opsi</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Opsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($options as $opt)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $opt->option_text }}</td>
                                    <td>
                                        @if ($opt->is_correct)
                                            <span class="badge badge-success">Benar</span>
                                        @else
                                            <span class="badge badge-danger">Salah</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click="deleteOption({{ $opt->id }})"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus opsi ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <p class="text-muted">Belum ada opsi untuk pertanyaan ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        // Auto dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endpush
