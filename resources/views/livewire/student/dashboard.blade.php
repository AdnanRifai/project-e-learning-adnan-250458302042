<div class="container mx-auto py-10">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-gray-50 to-white py-20 lg:py-32">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            Belajar Tanpa Batas dengan
                            <span class="text-primary">EduLearn</span>
                        </h1>
                        <p class="text-xl text-gray-600 leading-relaxed">
                            Platform e-learning terdepan yang menyediakan ribuan kursus berkualitas tinggi
                            dari instruktur terbaik di dunia. Mulai perjalanan belajar Anda hari ini.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button
                            class="px-8 py-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-semibold text-lg transition-colors">
                            Mulai Belajar Gratis
                        </button>
                        <button
                            class="px-8 py-4 border-2 border-gray-300 text-gray-900 hover:border-primary hover:text-primary rounded-lg font-semibold text-lg transition-colors">
                            Lihat Demo
                        </button>
                    </div>

                    <div class="flex items-center space-x-8 pt-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary">50K+</div>
                            <div class="text-gray-600">Siswa Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary">1000+</div>
                            <div class="text-gray-600">Kursus</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary">200+</div>
                            <div class="text-gray-600">Instruktur</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="public/students-learning-online-with-laptops-and-books-in.jpg"
                        alt="Students learning online" class="w-full h-auto rounded-2xl shadow-2xl" />
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-xl shadow-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <i data-lucide="play" class="h-6 w-6 text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Video Pembelajaran</div>
                                <div class="text-sm text-gray-600">HD Quality</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Kursus Populer</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Pilih dari ribuan kursus yang dirancang oleh para ahli untuk membantu Anda mencapai tujuan karir
        </p>
    </div>

    <h1 class="text-3xl font-bold mb-6 text-gray-800">Kursus Tersedia</h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($courses as $course)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                    class="w-full h-48 object-cover rounded-t-2xl" />
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                            {{ $course->category }}
                        </span>
                        <div class="flex items-center text-yellow-500">
                            <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            <span class="ml-1 text-sm font-medium text-gray-700">
                                {{ number_format($course->rating, 1) }}
                            </span>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                    <p class="text-gray-600 mb-4">
                        {{ Str::limit($course->description, 100) }}
                    </p>

                    <div class="flex items-center justify-between">
                        <div class="text-2xl font-bold text-primary">
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
</div>
