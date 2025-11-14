<nav class="sticky top-0 z-50 w-full border-b bg-white/95 backdrop-blur-sm shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <i data-lucide="book-open" class="h-8 w-8 text-primary"></i>
                <span class="text-xl font-bold text-gray-900">EduLearn</span>
            </div>

            <!-- Desktop Navigation -->
            <div class="desktop-nav hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-900 hover:text-primary transition-colors font-medium">Home</a>
                <a href="/courses" class="text-gray-900 hover:text-primary transition-colors font-medium">Course</a>

                <!-- Search Bar -->
                <div class="relative">
                    <i data-lucide="search"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4"></i>
                    <input type="search" placeholder="Cari kursus..."
                        class="pl-10 w-64 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:border-primary focus:outline-none focus:ring-2 focus:ring-red-100" />
                </div>
            </div>

            <!-- Desktop Auth Buttons -->
            <div class="desktop-nav hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}">
                        <button class="px-4 py-2 text-gray-900 hover:text-primary transition-colors font-medium">
                            Sign In
                        </button>
                    </a>
                    <a href="{{ route('register') }}">
                        <button class="px-6 py-2 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors">
                            Sign Up
                        </button>
                    </a>
                @endguest

                @auth
                    <a href="{{ route('student.dashboard') }}">
                        <button class="px-4 py-2 text-gray-900 hover:text-primary transition-colors font-medium">
                            Profile
                        </button>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="mobile-menu-btn md:hidden">
                <button id="mobile-menu-toggle" class="p-2 text-gray-900 hover:text-primary">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu md:hidden py-4 border-t">
            <div class="flex flex-col space-y-4">
                <a href="/" class="text-gray-900 hover:text-primary transition-colors font-medium">Home</a>
                <a href="/courses" class="text-gray-900 hover:text-primary transition-colors font-medium">Course</a>

                <!-- Mobile Search -->
                <div class="relative">
                    <i data-lucide="search"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4"></i>
                    <input type="search" placeholder="Cari kursus..."
                        class="pl-10 w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:border-primary focus:outline-none" />
                </div>

                <!-- Mobile Auth Buttons -->
                <div class="flex flex-col space-y-2 pt-4">
                    @guest
                        <a href="{{ route('login') }}">
                            <button class="px-4 py-2 text-gray-900 hover:text-primary transition-colors font-medium text-left">
                                Sign In
                            </button>
                        </a>
                        <a href="{{ route('register') }}">
                            <button class="px-6 py-2 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors">
                                Sign Up
                            </button>
                        </a>
                    @endguest

                    @auth
                        <a href="{{ route('student.dashboard') }}">
                            <button class="px-4 py-2 text-gray-900 hover:text-primary transition-colors font-medium text-left">
                                Profile
                            </button>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
