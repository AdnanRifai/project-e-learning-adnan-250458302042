<div class="p-6">
    <h2 class="text-xl font-semibold mb-3">
        Options untuk Question: <span class="text-blue-600">{{ $question->question_text }}</span>
    </h2>

    <a href="{{ route('option.create', $question->id) }}"
       class="px-4 py-2 bg-blue-600 text-white rounded mb-4 inline-block">
        Tambah Option
    </a>

    @if (session('success'))
        <div class="p-2 bg-green-200 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">#</th>
                <th class="p-3">Option</th>
                <th class="p-3">Correct?</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($options as $opt)
                <tr class="border-b">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3">{{ $opt->option_text }}</td>
                    <td class="p-3">
                        @if ($opt->is_correct)
                            <span class="text-green-600 font-semibold">Benar</span>
                        @else
                            <span class="text-red-600 font-semibold">Salah</span>
                        @endif
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('option.edit', [$question->id, $opt->id]) }}"
                            class="px-3 py-1 bg-yellow-500 text-white rounded">
                            Edit
                        </a>

                        <button wire:click="delete({{ $opt->id }})"
                                class="px-3 py-1 bg-red-600 text-white rounded">
                            Hapus
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
