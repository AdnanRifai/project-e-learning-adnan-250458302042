<div>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quiz Results | EduLearn</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
        <style>
            :root {
                --primary-color: #b30807;
                --primary-hover: #8b0606;
            }

            .bg-primary { background-color: var(--primary-color); }
            .text-primary { color: var(--primary-color); }
            .border-primary { border-color: var(--primary-color); }
            .hover\:bg-primary-hover:hover { background-color: var(--primary-hover); }

            .score-circle {
                animation: fillCircle 2s ease-in-out forwards;
            }

            @keyframes fillCircle {
                from {
                    stroke-dashoffset: 440;
                }
                to {
                    stroke-dashoffset: var(--score-offset);
                }
            }

            .fade-in {
                animation: fadeIn 0.5s ease-in;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .answer-correct {
                background-color: #dcfce7;
                border-color: #16a34a;
            }

            .answer-incorrect {
                background-color: #fee2e2;
                border-color: #dc2626;
            }

            .answer-option {
                transition: all 0.3s ease;
            }
        </style>
    </head>

    <body class="min-h-screen bg-gray-50">
        <!-- Top Navigation Bar -->
        <nav class="sticky top-0 z-50 w-full bg-white border-b shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-3">
                        <i data-lucide="graduation-cap" class="h-6 w-6 text-primary"></i>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">EduLearn</h1>
                            <p class="text-xs text-gray-500">E-Learning Platform</p>
                        </div>
                    </div>

                    <a href="{{ route('student.course.start', $quiz->lesson->module_id ?? 1) }}"
                       class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors flex items-center space-x-2">
                        <i data-lucide="arrow-left" class="h-4 w-4"></i>
                        <span class="hidden sm:inline">Back to Course</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Result Header -->
            <div class="bg-white rounded-xl shadow-sm border p-6 md:p-8 mb-6 fade-in">
                <div class="text-center mb-6">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Quiz Completed!</h1>
                    <p class="text-gray-600">Quiz: {{ $quiz->title }}</p>
                </div>

                <!-- Score Circle -->
                <div class="flex justify-center mb-6">
                    <div class="relative w-48 h-48">
                        <svg class="transform -rotate-90 w-48 h-48">
                            <circle
                                cx="96"
                                cy="96"
                                r="70"
                                stroke="#e5e7eb"
                                stroke-width="12"
                                fill="none"
                            />
                            <circle
                                id="score-circle"
                                cx="96"
                                cy="96"
                                r="70"
                                stroke="{{ $passed ? '#16a34a' : '#b30807' }}"
                                stroke-width="12"
                                fill="none"
                                stroke-dasharray="440"
                                stroke-dashoffset="440"
                                stroke-linecap="round"
                                class="score-circle"
                            />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-5xl font-bold text-gray-900">{{ number_format($percentage, 0) }}%</span>
                            <span class="text-sm text-gray-600 mt-1">Your Score</span>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $score }}</div>
                        <div class="text-sm text-gray-600 mt-1">Correct</div>
                    </div>

                    <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-red-600">{{ $total - $score }}</div>
                        <div class="text-sm text-gray-600 mt-1">Incorrect</div>
                    </div>

                    <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $total }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Questions</div>
                    </div>

                    <div class="bg-purple-50 border-2 border-purple-200 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-purple-600">--:--</div>
                        <div class="text-sm text-gray-600 mt-1">Time Taken</div>
                    </div>
                </div>

                <!-- Pass/Fail Status -->
                @if($passed)
                    <div class="mt-6 p-4 rounded-lg text-center bg-green-50 border-2 border-green-200">
                        <div class="flex items-center justify-center space-x-2 mb-2">
                            <i data-lucide="check-circle" class="h-6 w-6 text-green-600"></i>
                            <span class="text-xl font-bold text-green-600">Congratulations! You Passed!</span>
                        </div>
                        <p class="text-gray-600">You have successfully completed this quiz with a passing score.</p>
                    </div>
                @else
                    <div class="mt-6 p-4 rounded-lg text-center bg-red-50 border-2 border-red-200">
                        <div class="flex items-center justify-center space-x-2 mb-2">
                            <i data-lucide="x-circle" class="h-6 w-6 text-red-600"></i>
                            <span class="text-xl font-bold text-red-600">You Need More Practice</span>
                        </div>
                        <p class="text-gray-600">Don't worry! Review the material and try again to improve your score.</p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-6">
                    <a href="{{ route('student.course.start', $quiz->lesson->module_id ?? 1) }}"
                        class="w-full sm:w-auto px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors flex items-center justify-center space-x-2">
                        <i data-lucide="arrow-left" class="h-5 w-5"></i>
                        <span>Back to Course</span>
                    </a>

                    <button wire:click="toggleReview"
                        class="w-full sm:w-auto px-6 py-3 bg-white border-2 border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg font-medium transition-colors flex items-center justify-center space-x-2">
                        <i data-lucide="{{ $showReview ? 'eye-off' : 'eye' }}" class="h-5 w-5"></i>
                        <span>{{ $showReview ? 'Hide' : 'Review' }} Answers</span>
                    </button>

                    @if(!$passed)
                        <button wire:click="retryQuiz"
                            class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center space-x-2">
                            <i data-lucide="rotate-ccw" class="h-5 w-5"></i>
                            <span>Retry Quiz</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Detailed Review Section -->
            @if($showReview)
                <div class="space-y-4 fade-in">
                    <div class="bg-white rounded-xl shadow-sm border p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Detailed Review</h2>
                        <p class="text-gray-600 mb-6">Review your answers and see the correct solutions below.</p>

                        <!-- Question Reviews -->
                        <div class="space-y-6">
                            @foreach($questions as $q)
                                <div class="border-2 {{ $q['is_correct'] ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }} rounded-lg p-5">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $q['is_correct'] ? 'bg-green-600' : 'bg-red-600' }} text-white font-semibold text-sm">
                                                {{ $q['number'] }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $q['is_correct'] ? 'bg-green-600' : 'bg-red-600' }} text-white">
                                                <i data-lucide="{{ $q['is_correct'] ? 'check' : 'x' }}" class="h-3 w-3 mr-1"></i>
                                                {{ $q['is_correct'] ? 'Correct' : 'Incorrect' }}
                                            </span>
                                        </div>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $q['question_text'] }}</h3>

                                    <div class="space-y-2">
                                        @php
                                            $userSelectedOption = collect($q['options'])->firstWhere('is_selected', true);
                                            $correctOptionData = collect($q['options'])->firstWhere('is_correct_answer', true);
                                        @endphp

                                        @if($q['is_correct'])
                                            {{-- User answered correctly --}}
                                            <div class="p-3 rounded-lg border-2 border-green-600 bg-white">
                                                <div class="flex items-center space-x-2">
                                                    <i data-lucide="check-circle" class="h-5 w-5 text-green-600 flex-shrink-0"></i>
                                                    <span class="text-gray-900 font-medium">Your answer: {{ $userSelectedOption['option_text'] ?? 'Not answered' }}</span>
                                                </div>
                                            </div>
                                        @else
                                            {{-- User answered incorrectly --}}
                                            @if($userSelectedOption)
                                                <div class="p-3 rounded-lg border-2 border-red-600 bg-white mb-2">
                                                    <div class="flex items-center space-x-2">
                                                        <i data-lucide="x-circle" class="h-5 w-5 text-red-600 flex-shrink-0"></i>
                                                        <span class="text-gray-900 font-medium">Your answer: {{ $userSelectedOption['option_text'] }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="p-3 rounded-lg border-2 border-gray-400 bg-white mb-2">
                                                    <div class="flex items-center space-x-2">
                                                        <i data-lucide="minus-circle" class="h-5 w-5 text-gray-600 flex-shrink-0"></i>
                                                        <span class="text-gray-900 font-medium">Your answer: Not answered</span>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="p-3 rounded-lg border-2 border-green-600 bg-white">
                                                <div class="flex items-center space-x-2">
                                                    <i data-lucide="check-circle" class="h-5 w-5 text-green-600 flex-shrink-0"></i>
                                                    <span class="text-gray-900 font-medium">Correct answer: {{ $correctOptionData['option_text'] ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </main>

        <script>
            // Initialize Lucide icons
            document.addEventListener('DOMContentLoaded', () => {
                lucide.createIcons();
                animateScoreCircle();
            });

            // Reinitialize icons after Livewire updates
            document.addEventListener('livewire:update', () => {
                lucide.createIcons();
            });

            document.addEventListener('livewire:navigated', () => {
                lucide.createIcons();
                animateScoreCircle();
            });

            // Animate score circle
            function animateScoreCircle() {
                const scoreCircle = document.getElementById('score-circle');
                if (!scoreCircle) return;

                const percentage = {{ $percentage }};
                const circumference = 2 * Math.PI * 70;
                const offset = circumference - (percentage / 100) * circumference;

                scoreCircle.style.setProperty('--score-offset', offset);
            }

            // Listen for review toggle
            Livewire.on('reviewToggled', () => {
                setTimeout(() => {
                    lucide.createIcons();
                }, 100);
            });
        </script>
    </body>
</div>
