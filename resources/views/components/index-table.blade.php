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
        <x-breadcrumbs 
            :items="$breadcrumbs"
        />
        @if (!empty($actions))
            @if (isset($actions['create']))
                <x-button 
                    href="{{ route($actions['create']) }}"
                    class="h-8"
                    title="Tambah Data"
                    icon="plus"
                    size="md"
                />
            @endif
        @endif
    </div>


    @if (!empty($filters))
        <form 
            method="GET" 
            class="bg-white border border-zinc-100 rounded-lg overflow-hidden"
        >

            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100">
                <div>
                    <h1 class="text-sm font-semibold text-zinc-800">
                        Filter Data
                    </h1>

                    <p class="text-xs text-zinc-400 mt-1">
                        Gunakan filter untuk mencari data lebih spesifik
                    </p>
                </div>

                <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center">
                    <i data-lucide="sliders-horizontal" class="w-5 h-5 text-primary-600"></i>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="p-6 flex flex-col gap-6">

                <div class="grid md:grid-cols-3 gap-5">

                    @foreach ($filters as $filter)

                        @php
                            $colspan = isset($filter['colspan'])
                                ? 'md:col-span-' . $filter['colspan']
                                : 'md:col-span-1';
                        @endphp

                        {{-- TEXT / DATE --}}
                        @if ($filter['type'] === 'text' || $filter['type'] === 'date')

                            <div class="flex flex-col gap-2 {{ $colspan }}">

                                <label class="text-xs font-medium text-zinc-600">
                                    {{ $filter['label'] }}
                                </label>

                                <div class="relative">

                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">
                                        <i data-lucide="search" class="w-4 h-4"></i>
                                    </div>

                                    <input
                                        type="{{ $filter['type'] }}"
                                        name="{{ $filter['name'] }}"
                                        value="{{ request($filter['name']) }}"
                                        placeholder="{{ $filter['placeholder'] ?? '' }}"
                                        class="w-full h-11 pl-10 pr-4 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:border-primary-400"
                                    />

                                </div>

                            </div>

                        @endif

                        {{-- SELECT --}}
                        @if ($filter['type'] === 'select')

                            @php
                                $value = old($filter['name'], $filter['value'] ?? request($filter['name']));
                            @endphp

                            <div class="flex flex-col gap-2 {{ $colspan }}">

                                <label class="text-xs font-medium text-zinc-600">
                                    {{ $filter['label'] }}
                                </label>

                                <select
                                    name="{{ $filter['name'] }}"
                                    class="h-11 px-4 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:border-primary-400"

                                    @if(!empty($filter['required'])) required @endif
                                    @if(!empty($filter['disabled'])) disabled @endif
                                >

                                    {{-- Placeholder --}}
                                    <option value="">
                                        {{ $filter['placeholder'] ?? 'Semua Data' }}
                                    </option>

                                    @foreach ($filter['options'] as $option)

                                        <option
                                            value="{{ $option['value'] }}"
                                            {{ (string)$value === (string)$option['value'] ? 'selected' : '' }}
                                        >
                                            {{ $option['label'] }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        @endif

                    @endforeach

                </div>

                {{-- FOOTER --}}
                <div class="flex items-center justify-between border-t border-zinc-100 pt-5">

                    <p class="text-xs text-zinc-400">
                        
                    </p>

                    <div class="flex items-center gap-3">

                        <x-button 
                            type="submit"
                            title="Reset"
                            variant="outline"
                            size="md"
                            href="{{ url()->current() }}"
                        />

                        <x-button 
                            type="submit"
                            title="Terapkan Filter"
                            size="md"
                        />

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
                                        <img 
                                            src="{{ asset('storage/' . data_get($row, $col['field'])) }}"
                                            class="h-12 w-12 object-cover rounded"
                                            alt="image"
                                        >
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

                                    @if ($status === 'aman')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                            Aman
                                        </span>
                                    @elseif ($status === 'pesan_ulang')
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                            Pesan Ulang
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
                                    @if(isset($actions['edit']))
                                        <a 
                                            href="{{ route($actions['edit'], $row->id) }}"
                                            class="h-8 w-8 flex items-center justify-center text-xs rounded-full border text-blue-400 border-blue-200 hover:bg-blue-50"
                                        >
                                            <i data-lucide="pen" class="w-3 h-3"></i>
                                        </a>
                                    @endif

                                    {{-- SHOW --}}
                                    @if(isset($actions['show']))
                                        <a 
                                            href="{{ route($actions['show'], $row->id) }}"
                                            class="h-8 w-8 flex items-center justify-center text-xs rounded-full border text-green-400 border-green-200 hover:bg-green-50"
                                        >
                                            <i data-lucide="eye" class="w-3 h-3"></i>
                                        </a>
                                    @endif
        
                                    {{-- DELETE --}}
                                    @if(isset($actions['delete']))
                                        <form 
                                            id="delete-form-{{ $row->id }}"
                                            action="{{ route($actions['delete'], $row->id) }}"
                                            method="POST"
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button 
                                                type="button"
                                                onclick="confirmDelete({{ $row->id }})"
                                                class="h-8 w-8 flex items-center justify-center text-xs rounded-full border text-red-400 border-red-200 hover:bg-red-50 cursor-pointer"
                                            >
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
    
        @if($datas->hasPages())
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

