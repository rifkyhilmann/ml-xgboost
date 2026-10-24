<div class="flex flex-col gap-6">
    <x-breadcrumbs 
        :items="$breadcrumbs"
    />


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

    @if ($errors->any())
        <div
            x-data="{ open: true }"
            x-show="open"
            class="mb-4 relative flex items-center justify-between  rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700"
        >
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button
                type="button"
                @click="open = false"
                class=" text-red-500 hover:text-red-700"
            >
                ✕
            </button>

        </div>
    @endif

    <div
        class="bg-white shadow rounded-md"
    >
        <div class="h-12 border-b border-zinc-200 flex items-center px-4 gap-2">
            @if ($icon)
                <i data-lucide="{{ $icon }}" class="w-5 h-5 text-zinc-500"></i>
            @endif
            <h2 class="text-sm font-medium text-zinc-800">
                {{ $title }}
            </h2>
        </div>  

        <form 
            action="{{ $action }}"
            method="POST"
            enctype="multipart/form-data"
            class="flex flex-col gap-5 p-6"
        >
            @csrf

            @if($method === 'PUT' || $method === 'PATCH')
                @method($method)
            @endif


            <div class="grid md:grid-cols-3 gap-5">
                @foreach ($field as $f)
                    @if ($f['type'] == 'text' || $f['type'] == 'password' || $f['type'] == 'email' || $f['type'] == 'number' || $f['type'] == 'date')
                        @php
                            $colspan = isset($f['colspan']) 
                                ? 'md:col-span-' . $f['colspan'] 
                                : 'md:col-span-1';
                        @endphp

                        <div class="flex flex-col gap-1 {{ $colspan }}">
                            @if(!empty($f['label']))
                                <span class="text-xs">{{ $f['label'] }}</span>
                            @endif
                            <input 
                                id="{{ $f['id'] ?? '' }}"
                                type="{{ $f['type'] }}"
                                name="{{ $f['name'] }}"
                                placeholder="{{ $f['placeholder'] ?? '' }}"
                                @if(!empty($f['required'])) required @endif
                                value="{{ old($f['name'], $f['value'] ?? '') }}"
                                @if(!empty($f['disabled'])) disabled @endif
                                @if(!empty($f['readonly'])) readonly @endif
                                class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none placeholder:text-sm text-sm"
                            /> 
                        </div>
                    @elseif ($f['type'] == 'currency')
                        @php
                            $colspan = isset($f['colspan']) ? 'col-span-' . $f['colspan'] : 'col-span-1';
                        @endphp

                        <div class="flex flex-col gap-1 {{ $colspan }}">
                            @if(!empty($f['label']))
                                <span class="text-xs">{{ $f['label'] }}</span>
                            @endif
                            <input 
                                id="{{ $f['id'] ?? '' }}"
                                type="text"
                                name="{{ $f['name'] }}"
                                placeholder="{{ $f['placeholder'] ?? '' }}"
                                @if(!empty($f['required'])) required @endif
                                value="{{ old(
                                            $f['name'],
                                            isset($f['value']) ? number_format($f['value'], 0, ',', '.') : ''
                                        ) }}"
                                oninput="formatRupiah(this)"
                                @if(!empty($f['readonly'])) readonly @endif
                                class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none placeholder:text-sm text-sm"
                            /> 
                        </div>
                    @elseif ($f['type'] == 'select')
                        @php
                            $colspan = isset($f['colspan']) ? 'col-span-' . $f['colspan'] : 'col-span-1';
                            $value = old($f['name'], $f['value'] ?? '');
                        @endphp

                        <div class="flex flex-col gap-1 {{ $colspan }}">
                            @if(!empty($f['label']))
                                <span class="text-xs">{{ $f['label'] }}</span>
                            @endif

                            <select
                                name="{{ $f['name'] }}"
                                class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm"
                                @if(!empty($f['required'])) required @endif
                                @if(!empty($f['disabled'])) disabled @endif
                            >
                                {{-- Placeholder --}}
                                @if(!empty($f['placeholder']))
                                    <option value="">{{ $f['placeholder'] ?? '' }}</option>
                                @endif

                                @foreach ($f['options'] as $option)
                                    <option
                                        value="{{ $option['value'] }}"
                                        {{ $value == $option['value'] ? 'selected' : '' }}
                                    >
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif ($f['type'] == 'textarea')
                        @php
                            $colspan = isset($f['colspan']) ? 'col-span-' . $f['colspan'] : 'col-span-1';
                            $value = old($f['name'], $f['value'] ?? '');
                            $rows = $f['rows'] ?? 4;
                        @endphp

                        <div class="flex flex-col gap-1 {{ $colspan }}">
                            @if(!empty($f['label']))
                                <span class="text-xs">{{ $f['label'] }}</span>
                            @endif

                            <textarea
                                name="{{ $f['name'] }}"
                                rows="{{ $rows }}"
                                placeholder="{{ $f['placeholder'] ?? '' }}"
                                class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none text-sm resize-none"
                                @if(!empty($f['required'])) required @endif
                                @if(!empty($f['disabled'])) disabled @endif
                            >{{ $value }}</textarea>
                        </div>
                    @elseif ($f['type'] == 'checkbox')
                        @php
                            $colspan = isset($f['colspan']) ? 'col-span-' . $f['colspan'] : 'col-span-1';
                            $values = old($f['name'], $f['value'] ?? []);
                            if (!is_array($values)) {
                                $values = [$values];
                            }
                        @endphp

                        <div class="flex flex-col gap-2 {{ $colspan }}">
                            @if(!empty($f['label']))
                                <span class="text-xs">{{ $f['label'] }}</span>
                            @endif

                            <div class="flex flex-wrap gap-4">
                                @foreach ($f['options'] as $option)
                                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="{{ $f['name'] }}[]"
                                            value="{{ $option['value'] }}"
                                            class="rounded border-zinc-300"
                                            {{ in_array($option['value'], $values) ? 'checked' : '' }}
                                            @if(!empty($f['disabled'])) disabled @endif
                                        />
                                        {{ $option['label'] }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @elseif ($f['type'] == 'image')
                        @php
                            $colspan = isset($f['colspan']) ? 'col-span-' . $f['colspan'] : 'col-span-1';
                            $preview = $f['value'] ?? null;
                            $inputId = 'image-input-' . $loop->index;
                            $previewId = 'image-preview-' . $loop->index;
                        @endphp

                        <div class="flex flex-col gap-2 {{ $colspan }}">
                            @if(!empty($f['label']))
                                <span class="text-xs">{{ $f['label'] }}</span>
                            @endif

                            {{-- PREVIEW IMAGE LAMA / BARU --}}
                            <img
                                id="{{ $previewId }}"
                                src="{{ $preview ? asset('storage/' . $preview) : '' }}"
                                class="h-24 w-24 object-cover rounded border {{ $preview ? '' : 'hidden' }}"
                                alt="Preview"
                            >

                            {{-- INPUT FILE --}}
                            <input
                                id="{{ $inputId }}"
                                type="file"
                                name="{{ $f['name'] }}"
                                accept="image/*"
                                class="text-sm h-10 px-4 py-2.5 border border-zinc-200 rounded-lg focus:outline-none"
                                @if(!empty($f['disabled'])) disabled @endif
                                onchange="previewImage(this, '{{ $previewId }}')"
                            />
                        </div>
                    @endif

                @endforeach
            </div>

            {{ $slot }}

            <div class="w-full flex items-center justify-end gap-2">
                <x-button
                    title="Save"
                    type="submit"
                    size="md"
                    variant="primary"
                    icon="save"
                />
            </div>
        </form>
    </div>
</div>

