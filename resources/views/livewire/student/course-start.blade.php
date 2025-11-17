<div class="flex gap-4">

    <!-- Improved sidebar and content layout to match Laravel structure -->
    <div class="flex h-[calc(100vh-57px)] overflow-hidden">
        <!-- Sidebar - Course Modules with Lessons -->
        <aside id="course-sidebar"
            class="sidebar w-80 bg-gray-100 overflow-y-auto fixed lg:static inset-y-0 left-0 z-40 lg:z-0 h-full">
            <div class="p-4">
                @foreach ($modules as $index => $module)
                    <!-- Module {{ $index + 1 }} -->
                    <div class="mb-4">
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Section {{ $index + 1 }}:
                            {{ $module->title }}</h3>

                        <ul class="ml-3 space-y-1">
                            @foreach ($module->lessons as $lessonIndex => $lesson)
                                <li>
                                    <button wire:click="selectLesson({{ $lesson->id }})"
                                        class="lesson-btn w-full text-left py-2 px-3 rounded hover:bg-white transition-colors {{ $selectedLesson && $selectedLesson->id === $lesson->id ? 'text-primary font-semibold active-lesson' : 'text-gray-600 hover:underline' }}"
                                        data-lesson="{{ $index * count($module->lessons) + $lessonIndex + 1 }}"
                                        data-title="{{ $lesson->title }}"
                                        data-duration="{{ $lesson->duration ?? '00:00' }}">
                                        {{ $lesson->title }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-white">
            <div class="p-6">
                <div id="lesson-content">
                    @if ($selectedLesson)
                        <!-- Dynamic lesson content will be loaded here -->
                        <h1 class="text-2xl font-bold mb-3" id="lesson-title">{{ $selectedLesson->title }}</h1>

                        <div class="prose max-w-none" id="lesson-body">
                            {!! $selectedLesson->content !!}
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex items-center justify-between mt-8 pt-6 border-t">
                            <button wire:click="previousLesson"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors flex items-center space-x-2 {{ !$hasPreviousLesson ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ !$hasPreviousLesson ? 'disabled' : '' }}>
                                <i data-lucide="chevron-left" class="h-4 w-4"></i>
                                <span>Previous</span>
                            </button>

                            @if ($hasNextLesson)
                                <button wire:click="nextLesson"
                                    class="px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors flex items-center space-x-2">
                                    <span>Next</span>
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </button>
                            @else
                                <button wire:click="completeCourse"
                                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center space-x-2">
                                    <span>Complete Course</span>
                                    <i data-lucide="check-circle" class="h-4 w-4"></i>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i data-lucide="book-open" class="h-16 w-16 text-gray-300 mx-auto mb-4"></i>
                            <h2 class="text-xl font-semibold text-gray-600 mb-2">Selamat Datang di Kursus</h2>
                            <p class="text-gray-500">Pilih materi dari sidebar untuk mulai belajar</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>

        @if ($selectedLesson && $selectedLesson->quiz)
            <div
                class="mt-8 bg-gradient-to-r from-red-50 to-orange-50 border-2 border-primary rounded-xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                            <i data-lucide="clipboard-list" class="h-6 w-6 text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                {{ $selectedLesson->quiz->title }}
                            </h3>

                            <p class="text-gray-600 mb-4">
                                Ready to test your understanding for this lesson?
                            </p>

                            <div class="flex flex-wrap gap-3 items-center text-sm text-gray-600 mb-4">
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="help-circle" class="h-4 w-4"></i>
                                    <span>{{ $selectedLesson->quiz->questions->count() }} Questions</span>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <i data-lucide="target" class="h-4 w-4"></i>
                                    <span>Passing Score: {{ $selectedLesson->quiz->passing_score }}%</span>
                                </div>
                            </div>

                            <button wire:click="startQuiz({{ $selectedLesson->quiz->id }})"
                                class="px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors inline-flex items-center space-x-2">
                                 <i data-lucide="play-circle" class="h-5 w-5"></i>
                                <span>Start Quiz</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Sidebar toggle for mobile
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarToggleDesktop = document.getElementById('sidebar-toggle-desktop');
        const sidebar = document.getElementById('course-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('hidden-mobile');
            sidebarOverlay.classList.toggle('hidden');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
        if (sidebarToggleDesktop) {
            sidebarToggleDesktop.addEventListener('click', toggleSidebar);
        }
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }

        // Close sidebar on mobile after selecting lesson
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('lessonSelected', () => {
                if (window.innerWidth < 1024) {
                    toggleSidebar();
                }
            });
        });
    </script>
</div>
