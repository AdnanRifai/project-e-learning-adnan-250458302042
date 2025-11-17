<div class="flex gap-4">

    <!-- Improved sidebar and content layout to match Laravel structure -->
    <div class="flex h-[calc(100vh-57px)] overflow-hidden">
        <!-- Sidebar - Course Modules with Lessons -->
        <aside class="w-64 bg-white border-r overflow-y-auto hidden md:block">
            <div class="p-4">
                <div class="mb-4">
                    <h2 class="font-bold text-gray-900 mb-2">Questions</h2>
                    <p class="text-sm text-gray-600">Click on a question to navigate</p>
                </div>

                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 mb-2 uppercase">Progress</p>
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                @php
                                    $totalQuestions = count($questions);
                                    $answeredCount = count(array_filter($answers, fn($a) => !is_null($a)));
                                    $progressPercentage =
                                        $totalQuestions > 0 ? ($answeredCount / $totalQuestions) * 100 : 0;
                                @endphp
                                <div class="h-full bg-primary transition-all duration-300"
                                    style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">
                                {{ $answeredCount }}/{{ $totalQuestions }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-500 mb-2 uppercase">Question List</p>
                        <div class="grid grid-cols-5 gap-2">
                            @foreach ($questions as $idx => $question)
                                <button wire:click="goToQuestion({{ $idx }})"
                                    class="w-10 h-10 rounded flex items-center justify-center text-sm font-medium transition-all hover:scale-105
                            {{ $currentIndex === $idx
                                ? 'bg-primary text-white border-2 border-primary'
                                : (!is_null($answers[$idx] ?? null)
                                    ? 'bg-green-100 border-2 border-green-600 text-green-700'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200') }}">
                                    {{ $idx + 1 }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-3 border-t">
                        <div class="flex items-center space-x-3 text-xs">
                            <div class="flex items-center space-x-1">
                                <div class="w-4 h-4 bg-primary rounded"></div>
                                <span class="text-gray-600">Current</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-4 h-4 bg-green-100 border-2 border-green-600 rounded"></div>
                                <span class="text-gray-600">Answered</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-4 h-4 bg-gray-100 rounded"></div>
                                <span class="text-gray-600">Unanswered</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content - Question Area -->
        <main class="flex-1 overflow-y-auto p-6">
            @if (count($questions) > 0)
                @php $currentQuestion = $questions[$currentIndex]; @endphp

                <div class="max-w-3xl mx-auto">
                    <!-- Question Header -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-500">
                                Question {{ $currentIndex + 1 }} of {{ count($questions) }}
                            </span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                {{ ucfirst($currentQuestion['type']) }}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-6">
                            {{ $currentQuestion['question_text'] }}
                        </h3>

                        <!-- Options -->
                        <div class="space-y-3">
                            @foreach ($currentQuestion['options'] as $option)
                                <button wire:click="chooseOption({{ $currentIndex }}, {{ $option['id'] }})"
                                    class="w-full text-left p-4 rounded-lg border-2 transition-all
                                {{ ($answers[$currentIndex] ?? null) == $option['id']
                                    ? 'border-primary bg-primary bg-opacity-10'
                                    : 'border-gray-200 hover:border-gray-300' }}">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-6 h-6 rounded-full border-2 mr-3
                                    {{ ($answers[$currentIndex] ?? null) == $option['id'] ? 'border-primary bg-primary' : 'border-gray-300' }}">
                                            @if (($answers[$currentIndex] ?? null) == $option['id'])
                                                <svg class="w-full h-full text-white p-1" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="text-gray-700">{{ $option['option_text'] }}</span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center">
                        <button wire:click="prev" @if ($currentIndex === 0) disabled @endif
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            Previous
                        </button>

                        @if ($currentIndex < count($questions) - 1)
                            <button wire:click="next"
                                class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark">
                                Next
                            </button>
                        @else
                            <button wire:click="submitQuiz"
                                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Submit Quiz
                            </button>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">No questions available</p>
                </div>
            @endif
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
                                class="px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg">
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
