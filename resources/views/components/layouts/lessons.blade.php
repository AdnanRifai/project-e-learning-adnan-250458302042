<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Web Development - Learning | EduLearn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        :root {
            --primary-color: #b30807;
            --primary-hover: #8b0606;
            --secondary-color: #f8f9fa;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
        }

        .bg-primary { background-color: var(--primary-color); }
        .text-primary { color: var(--primary-color); }
        .border-primary { border-color: var(--primary-color); }
        .hover\:bg-primary-hover:hover { background-color: var(--primary-hover); }
        .focus\:border-primary:focus { border-color: var(--primary-color); }

        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.hidden-mobile {
            transform: translateX(-100%);
        }

        @media (min-width: 1024px) {
            .sidebar.hidden-mobile {
                transform: translateX(0);
            }
        }

        .lesson-item.active {
            background-color: #fef2f2;
            border-left: 4px solid var(--primary-color);
        }

        .lesson-item.completed {
            opacity: 0.7;
        }

        .lesson-item.completed .lesson-icon {
            background-color: #10b981;
            color: white;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            background-color: #000;
            border-radius: 0.5rem;
        }

        .video-container iframe,
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .progress-bar {
            height: 4px;
            background-color: #e5e7eb;
        }

        .progress-fill {
            height: 100%;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .tab-btn.active {
            border-bottom: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Top Navigation Bar -->
    <x-partials.user.lesssons.navbar/>

    <div class="flex h-[calc(100vh-57px)] overflow-hidden">
        <!-- Sidebar - Course Curriculum -->
        {{ $slot }}

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto">

        </main>
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

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarToggleDesktop.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Module toggle
        const moduleToggles = document.querySelectorAll('.module-toggle');

        moduleToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const moduleId = this.getAttribute('data-module');
                const moduleContent = document.getElementById(moduleId);
                const chevron = this.querySelector('[data-lucide^="chevron"]');

                moduleContent.classList.toggle('hidden');

                if (moduleContent.classList.contains('hidden')) {
                    chevron.setAttribute('data-lucide', 'chevron-right');
                } else {
                    chevron.setAttribute('data-lucide', 'chevron-down');
                }

                lucide.createIcons();
            });
        });

        // Lesson navigation
        const lessonItems = document.querySelectorAll('.lesson-item');

        lessonItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all lessons
                lessonItems.forEach(l => l.classList.remove('active'));

                // Add active class to clicked lesson
                this.classList.add('active');

                // Close sidebar on mobile after selecting lesson
                if (window.innerWidth < 1024) {
                    toggleSidebar();
                }

                // Here you would typically load the new lesson content
                console.log('[v0] Lesson clicked:', this.getAttribute('data-lesson'));
            });
        });

        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked button and corresponding content
                this.classList.add('active');
                document.getElementById(targetTab).classList.add('active');
            });
        });
    </script>
</body>
</html>
