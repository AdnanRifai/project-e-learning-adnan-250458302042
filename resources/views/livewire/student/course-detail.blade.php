<section class="bg-white py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Course Info -->
            <div class="lg:col-span-2">
                <!-- Level Badge -->
                <div class="flex items-center space-x-4 mb-6">
                    <span class="px-4 py-2 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                        {{ ucfirst($course->level ?? 'Beginner') }}
                    </span>
                    <div class="flex items-center text-yellow-500">
                        @for ($i = 0; $i < floor($course->rating ?? 5); $i++)
                            <i data-lucide="star" class="h-5 w-5 fill-current"></i>
                        @endfor
                        <span class="ml-2 text-lg font-semibold text-gray-700">
                            {{ number_format($course->rating ?? 5, 1) }}
                        </span>
                        <span class="ml-1 text-gray-500">( {{ $course->students_count ?? rand(200, 5000) }} reviews
                            )</span>
                    </div>
                </div>

                <!-- Course Title -->
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    {{ $course->title }}
                </h1>

                <!-- Course Description -->
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    {{ $course->description }}
                </p>

                <!-- Author Info -->
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center">
                        <span class="text-white text-xl font-bold">
                            {{ strtoupper(substr($course->instructor_name ?? 'JD', 0, 2)) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $course->instructor_name ?? 'John Doe' }}
                        </h3>
                        <p class="text-gray-600">{{ $course->instructor_title ?? 'Professional Instructor' }}</p>
                        <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                            <span class="flex items-center">
                                <i data-lucide="users" class="h-4 w-4 mr-1"></i>
                                {{ $course->students_count ?? '15,000+' }} students
                            </span>
                            <span class="flex items-center">
                                <i data-lucide="award" class="h-4 w-4 mr-1"></i>
                                {{ $course->experience_years ?? '5+' }} years experience
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Course Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i data-lucide="clock" class="h-8 w-8 text-primary mx-auto mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900">{{ $course->duration ?? 40 }}</div>
                        <div class="text-sm text-gray-600">Jam Video</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i data-lucide="play-circle" class="h-8 w-8 text-primary mx-auto mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900">{{ $course->video_lessons ?? 120 }}</div>
                        <div class="text-sm text-gray-600">Video Lessons</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i data-lucide="file-text" class="h-8 w-8 text-primary mx-auto mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900">{{ $course->assignments ?? 25 }}</div>
                        <div class="text-sm text-gray-600">Assignments</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i data-lucide="award" class="h-8 w-8 text-primary mx-auto mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900">1</div>
                        <div class="text-sm text-gray-600">Certificate</div>
                    </div>
                </div>
            </div>

            <!-- Course Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-6">
                        <!-- Course Image -->
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                            class="w-full h-48 object-cover rounded-xl mb-6" />

                        <!-- Price -->
                        <div class="text-center mb-6">
                            <div class="text-4xl font-bold text-primary mb-2">
                                Rp {{ number_format($course->price, 0, ',', '.') }}
                            </div>

                            @if ($course->original_price ?? false)
                                <div class="text-gray-500 line-through text-lg">
                                    Rp {{ number_format($course->original_price, 0, ',', '.') }}
                                </div>
                                <div class="text-green-600 font-semibold">
                                    {{ ceil((1 - $course->price / $course->original_price) * 100) }}% OFF
                                </div>
                            @endif
                        </div>

                        <!-- Enroll Button -->
                        @if ($course->price == 0)
                            <!-- Tombol Mulai Belajar -->
                            <a href="{{ route('student.course.start', $course->id) }}"
                                class="block w-full px-6 py-4 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-lg transition-colors mb-4 text-center">
                                Mulai Belajar!
                            </a>
                        @else
                            <!-- Tombol Daftar Sekarang -->
                            <button x-data @click="$dispatch('open-modal', { id: 'paymentModal' })"
                                class="block w-full px-6 py-4 bg-primary hover:bg-primary-hover text-white rounded-xl font-bold text-lg transition-colors mb-4 text-center">
                                Daftar Sekarang!
                            </button>

                            <!-- Modal Metode Pembayaran -->
                            <div x-data="{ open: false }"
                                x-on:open-modal.window="if ($event.detail.id === 'paymentModal') open = true"
                                x-show="open" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">
                                    <button @click="open = false"
                                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                                        <i data-lucide="x" class="w-5 h-5"></i>
                                    </button>

                                    <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Pilih Metode
                                        Pembayaran</h2>

                                    <div class="space-y-3">
                                        <button wire:click="bayar('qris')"
                                            class="w-full border border-gray-300 rounded-lg py-3 hover:bg-gray-100 flex items-center justify-center gap-2">
                                            <i data-lucide="qr-code" class="w-5 h-5 text-primary"></i>
                                            QRIS
                                        </button>

                                        <button wire:click="bayar('bank')"
                                            class="w-full border border-gray-300 rounded-lg py-3 hover:bg-gray-100 flex items-center justify-center gap-2">
                                            <i data-lucide="credit-card" class="w-5 h-5 text-primary"></i>
                                            Transfer Bank
                                        </button>

                                        <button wire:click="bayar('ewallet')"
                                            class="w-full border border-gray-300 rounded-lg py-3 hover:bg-gray-100 flex items-center justify-center gap-2">
                                            <i data-lucide="smartphone" class="w-5 h-5 text-primary"></i>
                                            E-Wallet
                                        </button>
                                    </div>

                                    <div class="mt-6 text-center">
                                        <button @click="open = false"
                                            class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Guarantee -->
                        <div class="text-center text-sm text-gray-600 mb-6">
                            <i data-lucide="shield-check" class="h-4 w-4 inline mr-1"></i>
                            30-day money-back guarantee
                        </div>

                        <!-- What's Included -->
                        <div class="space-y-3">
                            <h4 class="font-semibold text-gray-900 mb-3">This course includes:</h4>
                            <div class="flex items-center text-sm text-gray-600">
                                <i data-lucide="play-circle" class="h-4 w-4 mr-3 text-primary"></i>
                                40 hours on-demand video
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i data-lucide="file-text" class="h-4 w-4 mr-3 text-primary"></i>
                                25 coding exercises
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i data-lucide="download" class="h-4 w-4 mr-3 text-primary"></i>
                                Downloadable resources
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i data-lucide="smartphone" class="h-4 w-4 mr-3 text-primary"></i>
                                Access on mobile and TV
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i data-lucide="infinity" class="h-4 w-4 mr-3 text-primary"></i>
                                Full lifetime access
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i data-lucide="award" class="h-4 w-4 mr-3 text-primary"></i>
                                Certificate of completion
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
