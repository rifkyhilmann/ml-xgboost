@php
    $sizes = [
        'xs'    =>  'px-2 py-1 text-xs',
        'sm'    =>  'px-3 py-1.5 text-xs',
        'md'    =>  'px-4 py-2 text-sm',
        'lg'    =>  'px-6 py-3 text-base',
        'xl'    =>  'px-8 py-4 text-lg',
    ];

    $variants = [
        'primary'       => 'bg-primary-500 text-white hover:bg-primary-600',
        'secondary'     => 'bg-zinc-200 text-zinc-800 hover:bg-zinc-300',
        'outline'       => 'border text-primary-500 hover:bg-primary-500 hover:text-white border-primary-500',
        'danger'        => 'bg-red-600 text-white hover:bg-red-700',
        'link'          => 'text-zinc-800 hover:text-zinc-900',
    ];
@endphp


@if($href)
    <a
        href="{{ $href }}"
        class="
            inline-flex items-center justify-center rounded-lg
            {{ $sizes[$size] ?? $sizes['md'] }}
            {{ $variants[$variant] ?? $variants['primary'] }}
            {{ $class }}
        "
    >
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="w-4 h-4 mr-2"></i>
        @endif
        @if($title)
            {{ $title }}
        @endif
    </a>
@else 
    <button
        type="{{ $type }}"
        class="
            inline-flex items-center justify-center rounded-lg cursor-pointer
            {{ $sizes[$size] ?? $sizes['md'] }}
            {{ $variants[$variant] ?? $variants['primary'] }}
            {{ $class }}
        "
        type={{ $type }}
        {{ $attributes }}
    >
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="w-4 h-4 mr-2"></i>
        @endif

        @if($title)
            {{ $title }}
        @endif
    </button>
@endif