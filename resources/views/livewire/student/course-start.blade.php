<div class="flex gap-4"> <!-- Improved sidebar and content layout to match Laravel structure -->
    <div class="flex h-[calc(100vh-57px)] overflow-hidden"> <!-- Sidebar - Course Modules with Lessons -->
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
                                <li> <button wire:click="selectLesson({{ $lesson->id }})"
                                        class="lesson-btn w-full text-left py-2 px-3 rounded hover:bg-white transition-colors {{ $selectedLesson && $selectedLesson->id === $lesson->id ? 'text-primary font-semibold active-lesson' : 'text-gray-600 hover:underline' }}"
                                        data-lesson="{{ $index * count($module->lessons) + $lessonIndex + 1 }}"
                                        data-title="{{ $lesson->title }}"
                                        data-duration="{{ $lesson->duration ?? '00:00' }}"> {{ $lesson->title }}
                                    </button> </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </aside> <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-white">
            <div class="p-6">
                <div id="lesson-content">
                    @if ($selectedLesson)
                        <!-- Dynamic lesson content will be loaded here -->
                        <h1 class="text-2xl font-bold mb-3" id="lesson-title">{{ $selectedLesson->title }}</h1>
                        <div class="prose max-w-none" id="lesson-body"> {!! $selectedLesson->content !!} </div>
                        <!-- Navigation Buttons -->
                        <div class="flex items-center justify-between mt-8 pt-6 border-t"> <button
                                wire:click="previousLesson"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors flex items-center space-x-2 {{ !$hasPreviousLesson ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ !$hasPreviousLesson ? 'disabled' : '' }}> <i data-lucide="chevron-left"
                                    class="h-4 w-4"></i> <span>Previous</span> </button>
                            @if ($hasNextLesson)
                                <button wire:click="nextLesson"
                                    class="px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors flex items-center space-x-2">
                                    <span>Next</span> <i data-lucide="chevron-right" class="h-4 w-4"></i> </button>
                            @else
                                <button wire:click="completeCourse"
                                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center space-x-2">
                                    <span>Complete Course</span> <i data-lucide="check-circle" class="h-4 w-4"></i>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12"> <i data-lucide="book-open"
                                class="h-16 w-16 text-gray-300 mx-auto mb-4"></i>
                            <h2 class="text-xl font-semibold text-gray-600 mb-2">Selamat Datang di Kursus</h2>
                            <p class="text-gray-500">Pilih materi dari sidebar untuk mulai belajar</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
        @if ($selectedLesson && $selectedLesson->quiz)
            @php
                // Check if user has completed this quiz
                $userId = Auth::id();
                $quizId = $selectedLesson->quiz->id;

                // Get all user answers for this quiz
                $userAnswers = \App\Models\Answer::where('user_id', $userId)
                    ->where('quiz_id', $quizId)
                    ->get()
                    ->keyBy('question_id');

                // Calculate if quiz is completed and get results
                $totalQuestions = $selectedLesson->quiz->questions->count();
                $answeredCount = $userAnswers->count();
                $isCompleted = $answeredCount === $totalQuestions;

                // Calculate score if completed
                $correctAnswers = 0;
                $incorrectAnswers = 0;
                $percentage = 0;
                $passed = false;

                if ($isCompleted) {
                    foreach ($selectedLesson->quiz->questions as $question) {
                        $correctOption = $question->options->firstWhere('is_correct', 1);
                        $userAnswer = $userAnswers->get($question->id);

                        if ($correctOption && $userAnswer && $userAnswer->option_id == $correctOption->id) {
                            $correctAnswers++;
                        } else {
                            $incorrectAnswers++;
                        }
                    }

                    $percentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
                    $passed = $percentage >= $selectedLesson->quiz->passing_score;
                }
            @endphp

            <div
                class="mt-8 bg-gradient-to-r {{ $isCompleted ? ($passed ? 'from-green-50 to-emerald-50 border-green-500' : 'from-red-50 to-orange-50 border-red-500') : 'from-red-50 to-orange-50 border-primary' }} border-2 rounded-xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4 flex-1">
                        <div
                            class="w-12 h-12 {{ $isCompleted ? ($passed ? 'bg-green-600' : 'bg-red-600') : 'bg-primary' }} rounded-lg flex items-center justify-center flex-shrink-0">
                            <i data-lucide="{{ $isCompleted ? ($passed ? 'check-circle' : 'x-circle') : 'clipboard-list' }}"
                                class="h-6 w-6 text-white"></i>
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ $selectedLesson->quiz->title }}
                                </h3>

                                @if ($isCompleted)
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $passed ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                                        {{ $passed ? 'PASSED' : 'FAILED' }}
                                    </span>
                                @endif
                            </div>

                            @if ($isCompleted)
                                {{-- SHOW QUIZ RESULTS --}}
                                <p class="text-gray-600 mb-4">
                                    {{ $passed ? 'Congratulations! You have passed this quiz.' : 'You need more practice. Try again to improve your score.' }}
                                </p>

                                {{-- Score Summary --}}
                                <div
                                    class="bg-white rounded-lg p-4 mb-4 border-2 {{ $passed ? 'border-green-200' : 'border-red-200' }}">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm font-semibold text-gray-600">Your Score</span>
                                        <span
                                            class="text-2xl font-bold {{ $passed ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $percentage }}%
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-3 gap-3 text-center">
                                        <div class="bg-green-50 rounded-lg p-3">
                                            <div class="text-2xl font-bold text-green-600">{{ $correctAnswers }}</div>
                                            <div class="text-xs text-gray-600">Correct</div>
                                        </div>

                                        <div class="bg-red-50 rounded-lg p-3">
                                            <div class="text-2xl font-bold text-red-600">{{ $incorrectAnswers }}</div>
                                            <div class="text-xs text-gray-600">Wrong</div>
                                        </div>

                                        <div class="bg-blue-50 rounded-lg p-3">
                                            <div class="text-2xl font-bold text-blue-600">{{ $totalQuestions }}</div>
                                            <div class="text-xs text-gray-600">Total</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('student.quiz.result', ['quizId' => $quizId, 'userId' => $userId]) }}"
                                        class="px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors inline-flex items-center space-x-2">
                                        <i data-lucide="eye" class="h-5 w-5"></i>
                                        <span>View Detailed Results</span>
                                    </a>

                                    @if (!$passed)
                                        <button wire:click="retryQuiz({{ $quizId }})"
                                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors inline-flex items-center space-x-2">
                                            <i data-lucide="rotate-ccw" class="h-5 w-5"></i>
                                            <span>Retry Quiz</span>
                                        </button>
                                    @endif
                                </div>
                            @else
                                {{-- SHOW START QUIZ OPTION --}}
                                <p class="text-gray-600 mb-4">
                                    Ready to test your understanding for this lesson?
                                </p>

                                <div class="flex flex-wrap gap-3 items-center text-sm text-gray-600 mb-4">
                                    <div class="flex items-center space-x-2">
                                        <i data-lucide="help-circle" class="h-4 w-4"></i>
                                        <span>{{ $totalQuestions }} Questions</span>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <i data-lucide="target" class="h-4 w-4"></i>
                                        <span>Passing Score: {{ $selectedLesson->quiz->passing_score }}%</span>
                                    </div>
                                </div>

                                <button wire:click="startQuiz({{ $quizId }})"
                                    class="px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors inline-flex items-center space-x-2">
                                    <i data-lucide="play-circle" class="h-5 w-5"></i>
                                    <span>Start Quiz</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Add this script at the bottom of your blade file --}}
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    lucide.createIcons();
                });

                document.addEventListener('livewire:update', () => {
                    lucide.createIcons();
                });
            </script>
        @endpush

    </div> <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>
    <script>
        // Initialize Lucide icons lucide.createIcons(); // Sidebar toggle for mobile const sidebarToggle = document.getElementById('sidebar-toggle'); const sidebarToggleDesktop = document.getElementById('sidebar-toggle-desktop'); const sidebar = document.getElementById('course-sidebar'); const sidebarOverlay = document.getElementById('sidebar-overlay'); function toggleSidebar() { sidebar.classList.toggle('hidden-mobile'); sidebarOverlay.classList.toggle('hidden'); } if (sidebarToggle) { sidebarToggle.addEventListener('click', toggleSidebar); } if (sidebarToggleDesktop) { sidebarToggleDesktop.addEventListener('click', toggleSidebar); } if (sidebarOverlay) { sidebarOverlay.addEventListener('click', toggleSidebar); } // Close sidebar on mobile after selecting lesson document.addEventListener('livewire:initialized', () => { Livewire.on('lessonSelected', () => { if (window.innerWidth < 1024) { toggleSidebar(); } }); });
    </script>
</div>
