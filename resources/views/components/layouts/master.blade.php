    <!DOCTYPE html>
    <html lang="id" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>EduLearn - Platform E-Learning Terdepan</title>
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

            .mobile-menu { display: none; }
            .mobile-menu.active { display: block; }

            @media (max-width: 768px) {
                .desktop-nav { display: none; }
                .mobile-menu-btn { display: block; }
            }

            @media (min-width: 769px) {
                .desktop-nav { display: flex; }
                .mobile-menu-btn { display: none; }
            }
        </style>

        @livewireStyles
    </head>
    <body class="min-h-screen bg-white text-gray-900">
        <!-- Navigation -->
        <x-partials.user.sidebar/>

        <!-- Main Content -->
        {{ $slot }}

        <!-- Footer -->
        <x-partials.user.footer/>

        <script>
            // Initialize Lucide icons
            lucide.createIcons();

            // Mobile menu toggle
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = mobileMenuToggle.querySelector('[data-lucide="menu"]');

            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('active');

                // Toggle icon between menu and x
                if (mobileMenu.classList.contains('active')) {
                    menuIcon.setAttribute('data-lucide', 'x');
                } else {
                    menuIcon.setAttribute('data-lucide', 'menu');
                }

                // Reinitialize icons after changing
                lucide.createIcons();
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        </script>

        @livewireScripts

    </body>
    </html>
