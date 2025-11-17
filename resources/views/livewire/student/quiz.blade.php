<div>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $quiz->title }} | EduLearn</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
        <style>
            :root {
                --primary-color: #b30807;
                --primary-hover: #8b0606;
            }

            .bg-primary {
                background-color: var(--primary-color);
            }

            .text-primary {
                color: var(--primary-color);
            }

            .border-primary {
                border-color: var(--primary-color);
            }

            .hover\:bg-primary-hover:hover {
                background-color: var(--primary-hover);
            }

            .timer {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.7;
                }
            }
        </style>
    </head>

    <body class="min-h-screen bg-gray-50">
        <!-- Top Navigation Bar -->
        <nav class="sticky top-0 z-50 w-full bg-white border-b shadow-sm">
            <div class="flex items-center justify-between px-4 py-3">
                <!-- Left: Course Title -->
                <div class="flex items-center space-x-3">
                    <i data-lucide="clipboard-list" class="h-6 w-6 text-primary"></i>
                    <div>
                        <h1 class="font-semibold text-gray-900">{{ $quiz->title }}</h1>
                        <p class="text-xs text-gray-500">Passing Score: {{ $quiz->passing_score }}%</p>
                    </div>
                </div>

                <!-- Right: Timer & Exit -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 timer">
                        <i data-lucide="clock" class="h-5 w-5 text-primary"></i>
                        <span class="font-semibold text-lg" id="timer">30:00</span>
                    </div>
                    <button onclick="openModal('exit-modal')"
                        class="px-4 py-2 text-gray-700 hover:text-red-600 transition-colors font-medium">
                        <i data-lucide="x" class="h-5 w-5 inline"></i>
                        <span class="hidden sm:inline ml-1">Exit Quiz</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Main Quiz Layout -->
        <div class="flex h-[calc(100vh-65px)] overflow-hidden">
            <!-- Sidebar - Question Navigation -->
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
                                        $answeredCount = count(array_filter($answers, fn($a) => $a !== null));
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
                                        : (isset($answers[$idx]) && $answers[$idx] !== null
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

            <!-- Main Content - Question Display -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="max-w-4xl mx-auto p-6">
                    @if (isset($questions[$currentIndex]))
                        @php
                            $currentQuestion = $questions[$currentIndex];
                        @endphp

                        <!-- Question Card -->
                        <div class="bg-white rounded-xl shadow-sm border p-6 md:p-8">
                            <!-- Question Number -->
                            <div class="flex items-center justify-between mb-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary text-white">
                                    Question {{ $currentIndex + 1 }} of {{ count($questions) }}
                                </span>
                            </div>

                            <!-- Question Text -->
                            <div class="mb-6">
                                <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">
                                    {{ $currentQuestion['question_text'] }}
                                </h2>
                                <p class="text-sm text-gray-500">
                                    Select one answer
                                </p>
                            </div>

                            <!-- Answer Options -->
                            <div class="space-y-3">
                                @foreach ($currentQuestion['options'] as $option)
                                    <button wire:click="chooseOption({{ $currentIndex }}, {{ $option['id'] }})"
                                        class="w-full p-4 text-left border-2 rounded-lg transition-all
                                    {{ isset($answers[$currentIndex]) && $answers[$currentIndex] === $option['id']
                                        ? 'border-green-600 bg-green-50'
                                        : 'border-gray-200 hover:border-primary hover:bg-gray-50' }}">
                                        <div class="flex items-start space-x-3">
                                            <div
                                                class="w-6 h-6 rounded-full border-2 flex items-center justify-center flex-shrink-0 mt-0.5
                                            {{ isset($answers[$currentIndex]) && $answers[$currentIndex] === $option['id']
                                                ? 'border-green-600 bg-green-600'
                                                : 'border-gray-300' }}">
                                                @if (isset($answers[$currentIndex]) && $answers[$currentIndex] === $option['id'])
                                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                                @endif
                                            </div>
                                            <span
                                                class="flex-1 font-medium {{ isset($answers[$currentIndex]) && $answers[$currentIndex] === $option['id'] ? 'text-green-700' : 'text-gray-900' }}">
                                                {{ $option['option_text'] }}
                                            </span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="flex items-center justify-between mt-8 pt-6 border-t">
                                <button wire:click="prev" @if ($currentIndex === 0) disabled @endif
                                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i data-lucide="chevron-left" class="h-4 w-4"></i>
                                    <span>Previous</span>
                                </button>

                                @if ($currentIndex === count($questions) - 1)
                                    <button onclick="openModal('submit-modal')"
                                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors inline-flex items-center space-x-2">
                                        <i data-lucide="check-circle" class="h-5 w-5"></i>
                                        <span>Submit Quiz</span>
                                    </button>
                                @else
                                    <button wire:click="next"
                                        class="px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors flex items-center space-x-2">
                                        <span>Next</span>
                                        <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Mobile Question Navigator -->
                    <div class="md:hidden mt-4 bg-white rounded-xl shadow-sm border p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-semibold text-gray-900">Questions</h3>
                            @php
                                $answeredCountMobile = count(array_filter($answers, fn($a) => $a !== null));
                                $totalQuestionsMobile = count($questions);
                            @endphp
                            <span
                                class="text-sm text-gray-600">{{ $answeredCountMobile }}/{{ $totalQuestionsMobile }}</span>
                        </div>
                        <div class="grid grid-cols-5 gap-2">
                            @foreach ($questions as $idx => $question)
                                <button wire:click="goToQuestion({{ $idx }})"
                                    class="w-10 h-10 rounded flex items-center justify-center text-sm font-medium transition-all
                                {{ $currentIndex === $idx
                                    ? 'bg-primary text-white'
                                    : (isset($answers[$idx]) && $answers[$idx] !== null
                                        ? 'bg-green-100 border-2 border-green-600 text-green-700'
                                        : 'bg-gray-100 text-gray-700') }}">
                                    {{ $idx + 1 }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Exit Confirmation Modal -->
        <div id="exit-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6">
                <div class="flex items-start space-x-4 mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="alert-triangle" class="h-6 w-6 text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Exit Quiz?</h3>
                        <p class="text-gray-600 text-sm">Your progress will not be saved. Are you sure you want to exit?
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-3 justify-end">
                    <button onclick="closeModal('exit-modal')"
                        class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors">
                        Cancel
                    </button>
                    <a href="{{ route('student.course.start', $quiz->lesson->course_id ?? 1) }}"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                        Exit Quiz
                    </a>
                </div>
            </div>
        </div>

        <!-- Submit Confirmation Modal -->
        <div id="submit-modal"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6">
                <div class="flex items-start space-x-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="check-circle" class="h-6 w-6 text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Submit Quiz?</h3>
                        @php
                            $answeredCountModal = count(array_filter($answers, fn($a) => $a !== null));
                            $totalQuestionsModal = count($questions);
                        @endphp
                        <p class="text-gray-600 text-sm mb-3">
                            You have answered <span class="font-semibold">{{ $answeredCountModal }}</span> out of
                            <span class="font-semibold">{{ $totalQuestionsModal }}</span> questions.
                        </p>
                        <p class="text-gray-600 text-sm">Are you ready to submit your answers?</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3 justify-end">
                    <button onclick="closeModal('submit-modal')"
                        class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors">
                        Cancel
                    </button>
                    <button wire:click="submitQuiz"
                        class="px-4 py-2 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors">
                        Submit
                    </button>
                </div>
            </div>
        </div>

        <script>
            // Modal functions
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
                document.getElementById(modalId).classList.add('flex');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
                document.getElementById(modalId).classList.remove('flex');
            }

            // Timer functionality
            let timeLeft = 1800; // 30 minutes in seconds

            function updateTimer() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                const timerEl = document.getElementById('timer');
                timerEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // Change color when time is running out
                if (timeLeft <= 60) {
                    timerEl.classList.add('text-red-600');
                }

                if (timeLeft > 0) {
                    timeLeft--;
                } else {
                    // Auto submit when time's up
                    alert('Time is up! Your quiz will be submitted automatically.');
                    @this.call('submitQuiz');
                }
            }

            setInterval(updateTimer, 1000);

            // Initialize Lucide icons
            document.addEventListener('DOMContentLoaded', () => {
                lucide.createIcons();
            });

            // Re-initialize icons after Livewire updates
            document.addEventListener('livewire:update', () => {
                lucide.createIcons();
            });

            // Prevent accidental page leave
            window.addEventListener('beforeunload', function(e) {
                e.preventDefault();
                e.returnValue = '';
            });
        </script>
    </body>
</div>
