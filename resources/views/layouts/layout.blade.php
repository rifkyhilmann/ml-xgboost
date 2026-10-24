@extends('layouts.app')

@section('app-content')
    <div x-data="{
        showSidebar: window.innerWidth >= 768,
        init() {
            window.addEventListener('resize', () => {
                this.showSidebar = window.innerWidth >= 768
            })
        }
    }" class="flex w-full bg-white">
        <a class="sr-only" href="#main-content">skip to the main content</a>

        <!-- overlay mobile -->
        <div x-cloak x-show="showSidebar" class="fixed inset-0 z-10 bg-black/30 md:hidden" x-on:click="showSidebar = false"
            x-transition.opacity></div>

        <!-- SIDEBAR -->
        <nav x-cloak
            class="fixed top-0 left-0 z-20 h-screen w-64 bg-primary-900 border-r border-neutral-200 transition-transform duration-300 flex flex-col"
            :class="showSidebar ? 'translate-x-0' : '-translate-x-64'">

            <div class="h-14 w-full border-b border-primary-800 flex items-center gap-3 px-4">

                <img class="w-9 h-9 rounded-lg" src="{{ asset('assets/logo.png') }}" />

                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-semibold text-white">
                        BKPSDM Majalengka
                    </span>
                    <span class="text-[10px] text-zinc-300">
                        Machhine Learning XGBOOST
                    </span>
                </div>
            </div>

            @php
                $menus = [
                    [
                        'label' => 'Dashboard',
                        'route' => 'dashboard',
                        'icon' => 'layout-dashboard',
                        'role' => 'admin,superadmin',
                    ],
                    [
                        'label' => 'Master Data',
                        'icon' => 'folder-kanban',
                        'role' => 'admin,superadmin',
                        'children' => [
                            [
                                'label' => 'Pengguna',
                                'route' => 'kelola-pengguna.index',
                                'icon' => 'users',
                                'role' => 'admin,superadmin',
                            ],
                            [
                                'label' => 'Pegawai',
                                'route' => 'kelola-pegawai.index',
                                'icon' => 'contact-round',
                                'role' => 'admin,superadmin',
                            ],
                        ],
                    ],
                    [
                        'label' => 'Prediksi',
                        'route' => 'prediksi',
                        'icon' => 'brain-circuit',
                        'role' => 'admin,superadmin',
                    ],
                    [
                        'label' => 'Hasil Prediksi',
                        'route' => 'hasil-prediksi',
                        'icon' => 'chart-no-axes-column',
                        'role' => 'admin,superadmin',
                    ],
                    [
                        'label' => 'Logout',
                        'route' => 'logout',
                        'icon' => 'log-out',
                        'role' => 'admin,superadmin',
                        'method' => 'POST',
                    ],
                ];

                $user = auth()->user();
                $role = $user?->role;

                // Helper closure untuk cek role
                $checkRole = function ($rolesString) use ($role) {
                    if (!$rolesString) {
                        return true;
                    }
                    $allowedRoles = array_map('trim', explode(',', $rolesString));
                    return in_array($role, $allowedRoles);
                };
            @endphp

            <!-- Sidebar Menu Container -->
            <div class="flex-1 flex flex-col gap-1 mt-1 overflow-y-auto pb-10 px-4 pt-3">
                @foreach ($menus as $menu)
                    @php
                        $hasParentRole = $checkRole($menu['role'] ?? null);
                        $children = $menu['children'] ?? [];

                        // Filter anak menu berdasarkan role
                        $visibleChildren = array_filter($children, function ($child) use ($checkRole) {
                            return $checkRole($child['role'] ?? null);
                        });

                        $hasChildren = !empty($visibleChildren);

                        // Cek apakah ada child yang sedang aktif
                        $hasActiveChild = false;
                        foreach ($visibleChildren as $child) {
                            if (
                                isset($child['route']) &&
                                request()->routeIs(str_replace('.index', '.*', $child['route']))
                            ) {
                                $hasActiveChild = true;
                                break;
                            }
                        }

                        $isActive =
                            isset($menu['route']) && request()->routeIs(str_replace('.index', '.*', $menu['route']));
                    @endphp

                    {{-- Jika punya child yang dapat diakses oleh role saat ini --}}
                    @if ($hasChildren && $hasParentRole)
                        <div x-data="{ open: {{ $hasActiveChild ? 'true' : 'false' }} }" class="flex flex-col">
                            {{-- Parent Dropdown Toggle --}}
                            <button type="button" @click="open = !open"
                                :class="open ? 'sidebar-menu-active' : 'sidebar-menu-non-active'"
                                class="flex w-full cursor-pointer items-center justify-between rounded-md px-3 py-2 text-sm transition">
                                <div class="flex items-center gap-3">
                                    <i data-lucide="{{ $menu['icon'] }}" class="h-4 w-4"></i>
                                    <span>{{ $menu['label'] }}</span>
                                </div>
                                <span :class="open ? 'rotate-180' : ''"
                                    class="flex items-center transition-transform duration-200">
                                    <i data-lucide="chevron-down" class="h-4 w-4"></i>
                                </span>
                            </button>

                            {{-- Children Dropdown List --}}
                            <div x-show="open" x-collapse
                                class="ml-4 mt-1 flex flex-col gap-1 border-l border-slate-200 pl-3">
                                @foreach ($visibleChildren as $child)
                                    @php
                                        $isChildActive =
                                            isset($child['route']) &&
                                            request()->routeIs(str_replace('.index', '.*', $child['route']));
                                    @endphp
                                    <a href="{{ isset($child['route']) ? route($child['route']) : '#' }}"
                                        @click="if (window.innerWidth < 768) { showSidebar = false }"
                                        class="{{ $isChildActive ? 'sidebar-menu-active' : 'sidebar-menu-non-active' }} flex items-center gap-3 rounded-md px-3 py-1.5 text-xs transition">
                                        <i data-lucide="{{ $child['icon'] }}" class="h-3.5 w-3.5"></i>
                                        <span>{{ $child['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Single Menu (Tanpa Child) --}}
                    @elseif ($hasParentRole && isset($menu['route']))
                        @if (($menu['method'] ?? 'GET') === 'POST')
                            <form action="{{ route($menu['route']) }}" method="POST">
                                @csrf
                                <button type="submit" @click="if (window.innerWidth < 768) { showSidebar = false }"
                                    class="w-full cursor-pointer {{ $isActive ? 'sidebar-menu-active' : 'sidebar-menu-non-active' }} flex items-center gap-3 rounded-md px-3 py-2 text-sm transition">
                                    <i data-lucide="{{ $menu['icon'] }}" class="h-4 w-4"></i>
                                    <span>{{ $menu['label'] }}</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route($menu['route']) }}"
                                @click="if (window.innerWidth < 768) { showSidebar = false }"
                                class="{{ $isActive ? 'sidebar-menu-active' : 'sidebar-menu-non-active' }} flex items-center gap-3 rounded-md px-3 py-2 text-sm transition">
                                <i data-lucide="{{ $menu['icon'] }}" class="h-4 w-4"></i>
                                <span>{{ $menu['label'] }}</span>
                            </a>
                        @endif
                    @endif
                @endforeach
            </div>


        </nav>


        <!-- MAIN CONTENT -->
        <div class="flex flex-col flex-1  h-screen overflow-x-hidden" :class="showSidebar ? 'md:ml-64' : 'ml-0'">
            <nav class="h-14 bg-white shadow flex items-center justify-between px-6 border-b border-zinc-200">
                <div class="flex items-center justify-center">
                    <button {{-- class="md:hidden" --}} @click="showSidebar = !showSidebar">
                        <i data-lucide="panel-left" class="w-5 h-5 text-slate-700 cursor-pointer hover:text-slate-800"></i>
                    </button>
                </div>

                <div class="flex items-center gap-3">

                    <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5 text-primary-600"></i>
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="text-xs font-semibold text-slate-800">
                            {{ auth()->user()->email }}
                        </span>
                        <span class="text-[10px] text-slate-500 capitalize">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>
            </nav>

            <main id="main-content" class="flex-1 overflow-y-auto p-6 bg-[#F8FAFB]">
                @yield('content')
            </main>
        </div>
    </div>
@endsection
