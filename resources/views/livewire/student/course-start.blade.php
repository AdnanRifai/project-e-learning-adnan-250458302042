<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-1/4 border-r bg-white">
        <livewire:student.course-sidebar :course="$course" />
    </aside>

    <!-- Konten utama -->
    <main class="flex-1 p-8 bg-gray-50">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $course->title }}</h1>
            <p class="text-gray-700 leading-relaxed mb-6">{{ $course->description }}</p>

            <div class="border-t border-gray-200 pt-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Selamat belajar 🎓</h2>
                <p class="text-gray-600 text-sm">Pilih modul di sidebar untuk mulai pelajaran pertama.</p>
            </div>
        </div>
    </main>
</div>
