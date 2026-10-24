<nav class="text-sm font-medium text-neutral-600" aria-label="breadcrumb">
    <ol class="flex flex-wrap items-center gap-1">
        @foreach ($items as $item)
            <li class="flex items-center gap-1 text-lg">
                @if (!empty($item['url']) && empty($item['active']))
                    <a 
                        href="{{ $item['url'] }}" 
                        class="hover:text-neutral-900"
                    >
                        {{ $item['label'] }}
                    </a>
                    <i data-lucide="chevron-right" class="h-4.5 w-4.5"></i>
                @else
                    <span 
                        class="text-neutral-900 font-medium"
                        aria-current="page"
                    >
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
