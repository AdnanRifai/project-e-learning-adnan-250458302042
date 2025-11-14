<div class="bg-white border-r border-gray-200 h-full overflow-y-auto rounded-lg shadow-sm p-5">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">
        Daftar Modul
    </h2>

    @if ($modules->isEmpty())
        <p class="text-gray-500 text-sm">Belum ada modul untuk course ini.</p>
    @else
        <div class="space-y-4">
            @foreach ($modules as $module)
                <div class="border border-gray-100 rounded-lg p-3">
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">
                        {{ $loop->iteration }}. {{ $module->title }}
                    </h3>

                    @if ($module->lessons->isEmpty())
                        <p class="text-gray-500 text-sm ml-2">Belum ada lesson.</p>
                    @else
                        <ul class="ml-4 space-y-1">
                            @foreach ($module->lessons as $lesson)
                                <li>
                                    <a href="{{ route('student.lesson.show', [$module->id, $lesson->id]) }}"
                                        class="block px-3 py-1.5 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                                        {{ $lesson->title }}
                                    </a>

                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
