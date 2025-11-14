<div>
    <!-- Hero Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Temukan Kursus <span class="text-primary">Terbaik</span> untuk Anda
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Jelajahi ribuan kursus berkualitas tinggi dari berbagai kategori dan tingkatkan keterampilan Anda
                    bersama instruktur terbaik.
                </p>

                <!-- Enhanced Search -->
                <div class="relative max-w-2xl mx-auto">
                    <i data-lucide="search"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5"></i>
                    <input type="search" placeholder="Apa yang ingin Anda pelajari hari ini?"
                        class="pl-12 pr-4 w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:border-primary focus:outline-none focus:ring-2 focus:ring-red-100 text-lg" />
                    <button
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 px-6 py-2 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors">
                        Cari
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters and Course Grid -->
    <section class="py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="flex flex-wrap gap-4 mb-8 justify-center">
                <button
                    class="filter-btn active px-6 py-3 rounded-full border border-gray-200 hover:border-primary transition-colors font-medium"
                    data-category="all">
                    Semua Kursus
                </button>
                <button
                    class="filter-btn px-6 py-3 rounded-full border border-gray-200 hover:border-primary transition-colors font-medium"
                    data-category="programming">
                    Programming
                </button>
                <button
                    class="filter-btn px-6 py-3 rounded-full border border-gray-200 hover:border-primary transition-colors font-medium"
                    data-category="design">
                    Design
                </button>
                <button
                    class="filter-btn px-6 py-3 rounded-full border border-gray-200 hover:border-primary transition-colors font-medium"
                    data-category="marketing">
                    Marketing
                </button>
                <button
                    class="filter-btn px-6 py-3 rounded-full border border-gray-200 hover:border-primary transition-colors font-medium"
                    data-category="business">
                    Business
                </button>
                <button
                    class="filter-btn px-6 py-3 rounded-full border border-gray-200 hover:border-primary transition-colors font-medium"
                    data-category="data">
                    Data Science
                </button>
            </div>

            @if ($courses->count() > 0)
                <!-- Sort and View Options -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                    <div class="text-gray-600">
                        @if (method_exists($courses, 'total'))
                            Menampilkan <span
                                class="font-semibold">{{ $courses->firstItem() }}-{{ $courses->lastItem() }}</span> dari
                            <span class="font-semibold">{{ $courses->total() }}</span> kursus
                        @else
                            Menampilkan <span class="font-semibold">{{ $courses->count() }}</span> kursus
                        @endif
                    </div>
                    <div class="flex items-center space-x-4">
                        <select
                            class="px-4 py-2 border border-gray-200 rounded-lg focus:border-primary focus:outline-none">
                            <option>Urutkan: Terpopuler</option>
                            <option>Urutkan: Terbaru</option>
                            <option>Urutkan: Rating Tertinggi</option>
                            <option>Urutkan: Harga Terendah</option>
                            <option>Urutkan: Harga Tertinggi</option>
                        </select>
                    </div>
                </div>

                <!-- Course Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="course-grid">
                    @foreach ($courses as $course)
                        <!-- Course Card -->
                        <div class="course-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow border border-gray-100"
                            data-category="programming">
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                                class="w-full h-48 object-cover rounded-t-2xl" />
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                        {{ $course->category }}
                                    </span>
                                    <div class="flex items-center text-yellow-500">
                                        <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                                        <span
                                            class="ml-1 text-sm font-medium text-gray-700">{{ number_format($course->rating, 1) }}</span>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ Str::limit($course->description, 80) }}
                                </p>
                                <div class="flex items-center mb-3 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <div
                                            class="w-6 h-6 bg-primary rounded-full flex items-center justify-center mr-2">
                                            <span class="text-white text-xs font-semibold">
                                                {{ strtoupper(substr($course->user->name ?? 'Unknown', 0, 2)) }}
                                            </span>
                                        </div>
                                        <span>{{ $course->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center mb-4 text-sm text-gray-500">
                                    <i data-lucide="clock" class="h-4 w-4 mr-1"></i>
                                    <span class="mr-4">{{ $course->duration ?? '0' }} jam</span>
                                    <i data-lucide="users" class="h-4 w-4 mr-1"></i>
                                    <span>{{ number_format($course->students_count ?? 0) }} siswa</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="text-xl font-bold text-primary">
                                        Rp {{ number_format($course->price, 0, ',', '.') }}
                                    </div>
                                    <a wire:navigate href="{{ route('student.course.detail', $course->id) }}"
                                        class="px-4 py-2 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors">
                                        Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-16 px-4">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i data-lucide="book-open" class="h-12 w-12 text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Kursus Tidak Tersedia</h3>
                    <p class="text-gray-600 text-center max-w-md mb-6">
                        Maaf, saat ini belum ada kursus yang tersedia. Silakan coba lagi nanti atau hubungi kami untuk
                        informasi lebih lanjut.
                    </p>
                    <a href="{{ route('home') }}"
                        class="px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-primary">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-4xl font-bold text-white mb-6">
                    Tidak Menemukan Kursus yang Anda Cari?
                </h2>
                <p class="text-xl text-red-100 mb-8">
                    Hubungi tim kami untuk mendapatkan rekomendasi kursus yang sesuai dengan kebutuhan dan tujuan karir
                    Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button
                        class="px-8 py-4 bg-white text-primary hover:bg-gray-100 rounded-lg font-semibold text-lg transition-colors">
                        Hubungi Kami
                    </button>
                    <button
                        class="px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-primary rounded-lg font-semibold text-lg transition-colors">
                        Request Kursus
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>
