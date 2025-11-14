<!-- Top Navigation Bar -->
<nav class="sticky top-0 z-50 w-full bg-white border-b shadow-sm">
    <div class="flex items-center justify-between px-4 py-3">
        <!-- Left: Menu Toggle & Course Title -->
        <div class="flex items-center space-x-4">
            <button id="sidebar-toggle" class="p-2 hover:bg-gray-100 rounded-lg lg:hidden">
                <i data-lucide="menu" class="h-6 w-6 text-gray-700"></i>
            </button>
            <button id="sidebar-toggle-desktop" class="p-2 hover:bg-gray-100 rounded-lg hidden lg:block">
                <i data-lucide="panel-left" class="h-6 w-6 text-gray-700"></i>
            </button>
            <div class="flex items-center space-x-2">
                <i data-lucide="book-open" class="h-6 w-6 text-primary"></i>
                <span class="font-semibold text-gray-900 hidden sm:block">Complete Web Development</span>
            </div>
        </div>

        <!-- Right: Progress & Exit -->
        <div class="flex items-center space-x-4">
            <div class="hidden md:flex items-center space-x-2">
                <span class="text-sm text-gray-600">Progress:</span>
                <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="progress-fill" style="width: 35%"></div>
                </div>
                <span class="text-sm font-semibold text-primary">35%</span>
            </div>
            <a href="course-detail.html"
                class="px-4 py-2 text-gray-700 hover:text-primary transition-colors font-medium">
                <i data-lucide="x" class="h-5 w-5 inline"></i>
                <span class="hidden sm:inline ml-1">Exit</span>
            </a>
        </div>
    </div>

    <!-- Mobile Progress Bar -->
    <div class="progress-bar md:hidden">
        <div class="progress-fill" style="width: 35%"></div>
    </div>
</nav>
