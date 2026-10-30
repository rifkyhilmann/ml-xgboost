@if (session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            customClass: {
                popup: 'text-sm',
                title: 'text-sm font-medium',
            }
        });
    </script>
@endif

<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <x-breadcrumbs :items="$breadcrumbs" />
        @if (!empty($actions))
            @if (isset($actions['create']))
                <x-button href="{{ route($actions['create']) }}" class="h-8" title="Tambah Data" icon="plus"
                    size="md" />
            @endif
        @endif
    </div>


    @if (!empty($filters))
        <form method="GET" class="bg-white rounded-xl shadow-sm border border-zinc-200/80 mb-6">
            {{-- HEADER MODERN & RESET INLINE --}}
            <div
                class="px-5 py-3.5 flex items-center justify-between border-b border-zinc-100 bg-zinc-50/50 rounded-t-xl">
                <div class="flex items-center gap-3">
                    <div
                        class="w-7 h-7 rounded bg-white border border-zinc-200 flex items-center justify-center shadow-sm">
                        <i data-lucide="filter" class="w-3.5 h-3.5 text-zinc-600"></i>
                    </div>
                    <h2 class="text-sm font-semibold text-zinc-800 tracking-tight">Kriteria Pencarian</h2>
                </div>

                {{-- Tombol Reset dipindah ke header agar lebih rapi --}}
                <a href="{{ url()->current() }}"
                    class="text-xs font-medium text-zinc-500 hover:text-zinc-900 transition-colors flex items-center gap-1.5 px-2 py-1 rounded hover:bg-zinc-200/50">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    Reset Filter
                </a>
            </div>

            {{-- CONTENT GRID --}}
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 items-end">

                    @foreach ($filters as $filter)
                        @php
                            $colspan = isset($filter['colspan']) ? 'md:col-span-' . $filter['colspan'] : 'col-span-1';
                        @endphp

                        {{-- TEXT / DATE --}}
                        @if ($filter['type'] === 'text' || $filter['type'] === 'date')
                            <div class="flex flex-col gap-1.5 {{ $colspan }}">
                                <label class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
                                    {{ $filter['label'] }}
                                </label>

                                <div class="relative group">
                                    <div
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-primary-500 transition-colors">
                                        <i data-lucide="{{ $filter['type'] === 'date' ? 'calendar' : 'search' }}"
                                            class="w-4 h-4"></i>
                                    </div>
                                    <input type="{{ $filter['type'] }}" name="{{ $filter['name'] }}"
                                        value="{{ request($filter['name']) }}"
                                        placeholder="{{ $filter['placeholder'] ?? 'Ketik kata kunci...' }}"
                                        class="w-full h-10 pl-9 pr-3 bg-zinc-50 border border-zinc-200 text-zinc-700 text-sm rounded-lg transition-all focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none placeholder:text-zinc-400" />
                                </div>
                            </div>
                        @endif

                        {{-- SELECT --}}
                        @if ($filter['type'] === 'select')
                            @php
                                $value = old($filter['name'], $filter['value'] ?? request($filter['name']));
                            @endphp
                            <div class="flex flex-col gap-1.5 {{ $colspan }}">
                                <label class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
                                    {{ $filter['label'] }}
                                </label>

                                <select name="{{ $filter['name'] }}"
                                    class="w-full h-10 px-3 bg-zinc-50 border border-zinc-200 text-zinc-700 text-sm rounded-lg transition-all focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none appearance-none cursor-pointer"
                                    @if (!empty($filter['required'])) required @endif
                                    @if (!empty($filter['disabled'])) disabled @endif>
                                    <option value="" class="text-zinc-400">
                                        {{ $filter['placeholder'] ?? 'Semua Kategori' }}
                                    </option>

                                    @foreach ($filter['options'] as $option)
                                        <option value="{{ $option['value'] }}"
                                            {{ (string) $value === (string) $option['value'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endforeach

                    {{-- TOMBOL TERAPKAN FILTER (Menyatu di dalam grid) --}}
                    <div class="col-span-1 flex justify-start mt-2 md:mt-0">
                        <x-button type="submit" title="Terapkan" size="md"
                            class="w-full md:w-auto h-10 shadow-sm font-medium" />
                    </div>

                </div>
            </div>
        </form>
    @endif


    <div class="overflow-x-auto rounded shadow-sm">
        <table class="w-full text-sm">
            {{-- HEADER --}}
            <thead class="bg-zinc-50 border-b border-zinc-100">
                <tr>
                    @foreach ($columns as $col)
                        <th class="px-4 py-3 text-left font-semibold text-zinc-700 {{ $col['class'] ?? '' }}">
                            {{ $col['label'] }}
                        </th>
                    @endforeach

                    @if (!empty($actions))
                        <th class="px-4 py-3 text-left font-semibold text-zinc-700 w-32">
                            Action
                        </th>
                    @endif
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="divide-y">
                @forelse ($datas as $row)
                    <tr class="bg-white transition border-b border-zinc-100 {{ $row['class'] ?? '' }}">
                        @foreach ($columns as $col)
                            <td class="px-4 py-3 text-zinc-700">
                                @if (($col['type'] ?? 'text') === 'image')
                                    @if (data_get($row, $col['field']))
                                        <img src="{{ asset('storage/' . data_get($row, $col['field'])) }}"
                                            class="h-12 w-12 object-cover rounded" alt="image">
                                    @else
                                        <span class="text-xs text-zinc-400">No Image</span>
                                    @endif
                                @elseif (($col['type'] ?? 'text') === 'currency')
                                    <span class="text-sm">
                                        Rp {{ number_format(data_get($row, $col['field']), 0, ',', '.') }}
                                    </span>
                                @elseif (($col['type'] ?? 'text') === 'status')
                                    @php
                                        $status = data_get($row, $col['field']);
                                    @endphp

                                    @if ($status === 'Layak')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                            Layak
                                        </span>
                                    @elseif ($status === 'Tidak Layak')
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                            Tidak Layak
                                        </span>
                                    @endif
                                @elseif (($col['type'] ?? 'text') === 'date')
                                    @php
                                        $date = data_get($row, $col['field']);
                                    @endphp

                                    @if ($date)
                                        {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}
                                    @else
                                        <span class="text-xs text-zinc-400">-</span>
                                    @endif
                                @else
                                    {{ data_get($row, $col['field']) }}
                                @endif
                            </td>
                        @endforeach
                        @if (!empty($actions))
                            <td class="px-4 py-3 text-left">
                                <div class="flex justify-start gap-2">

                                    {{-- EDIT --}}
                                    @if (isset($actions['edit']))
                                        <a href="{{ route($actions['edit'], $row->id) }}"
                                            class="h-8 w-8 flex items-center justify-center text-xs rounded-full border text-blue-400 border-blue-200 hover:bg-blue-50">
                                            <i data-lucide="pen" class="w-3 h-3"></i>
                                        </a>
                                    @endif

                                    {{-- SHOW --}}
                                    @if (isset($actions['show']))
                                        <a href="{{ route($actions['show'], $row->id) }}"
                                            class="h-8 w-8 flex items-center justify-center text-xs rounded-full border text-green-400 border-green-200 hover:bg-green-50">
                                            <i data-lucide="eye" class="w-3 h-3"></i>
                                        </a>
                                    @endif

                                    {{-- DELETE --}}
                                    @if (isset($actions['delete']))
                                        <form id="delete-form-{{ $row->id }}"
                                            action="{{ route($actions['delete'], $row->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" onclick="confirmDelete({{ $row->id }})"
                                                class="h-8 w-8 flex items-center justify-center text-xs rounded-full border text-red-400 border-red-200 hover:bg-red-50 cursor-pointer">
                                                <i data-lucide="trash" class="w-3 h-3"></i>
                                            </button>
                                        </form>
                                    @endif


                                </div>
                            </td>
                        @endif

                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + (isset($actions['edit']) ? 1 : 0) }}"
                            class="px-6 py-10 text-center text-zinc-400">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($datas->hasPages())
            <div class="flex items-center justify-end gap-3 px-4 py-2 border-t border-zinc-200 bg-white">
                {{ $datas->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>


<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin hapus?',
            text: 'Data akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            customClass: {
                title: 'text-sm',
                popup: 'text-sm',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
