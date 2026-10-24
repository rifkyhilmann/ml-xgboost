
@extends('layouts.app')

@section('app-content')

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

<section class="min-h-screen bg-zinc-50 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-100">

        {{-- LOGO & COMPANY --}}
        <div class="mb-8 flex flex-col items-center text-center">
            <img
                src="{{ asset('assets/logo.png') }}"
                alt="Logo Perusahaan"
                class="h-28 w-30 object-contain"
            >

            <h1 class="text-lg font-bold tracking-tight text-zinc-900 mt-2">
                BPKSM Majelengka
            </h1>
        </div>

        {{-- LOGIN CARD --}}
        <div class="rounded-xl border border-zinc-200 bg-white shadow-sm">

            <div class="p-6 sm:p-8">

                {{-- HEADER --}}
                <div class="mb-4 flex items-center flex-col gap-1">
                    <h2 class="text-xl font-semibold tracking-tight text-zinc-900">
                        Selamat Datang
                    </h2>

                    <p class="text-sm text-center text-zinc-500">
                        Masuk menggunakan akun Anda untuk melanjutkan ke sistem.
                    </p>
                </div>

                {{-- ERROR --}}
                @if (session('error'))
                    <div class="mb-5 flex gap-3 rounded-lg border border-red-200 bg-red-50 p-3.5">
                        <i data-lucide="circle-alert"
                           class="mt-0.5 h-4 w-4 shrink-0 text-red-600"></i>

                        <p class="text-sm leading-relaxed text-red-700">
                            {{ session('error') }}
                        </p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 flex gap-3 rounded-lg border border-red-200 bg-red-50 p-3.5">
                        <i data-lucide="circle-alert"
                           class="mt-0.5 h-4 w-4 shrink-0 text-red-600"></i>

                        <div class="text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- FORM --}}
                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="flex flex-col gap-5"
                >
                    @csrf

                    {{-- EMAIL --}}
                    <div class="flex flex-col gap-2">
                        <label
                            for="email"
                            class="text-sm font-medium text-zinc-900"
                        >
                            Email
                        </label>

                        <div class="relative">
                            <i data-lucide="mail"
                               class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400"></i>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nama@email.com"
                                class="flex h-10 w-full rounded-md border border-zinc-200 bg-white pl-10 pr-3 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-500/10"
                            >
                        </div>
                    </div>

                    {{-- PASSWORD --}}
                    <div
                        x-data="{ show: false }"
                        class="flex flex-col gap-2"
                    >
                        <label
                            for="password"
                            class="text-sm font-medium text-zinc-900"
                        >
                            Kata Sandi
                        </label>

                        <div class="relative">
                            <i data-lucide="lock-keyhole"
                               class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400"></i>

                            <input
                                id="password"
                                :type="show ? 'text' : 'password'"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi"
                                class="flex h-10 w-full rounded-md border border-zinc-200 bg-white pl-10 pr-11 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-500/10"
                            >

                            <button
                                type="button"
                                @click="show = !show"
                                :aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                class="absolute right-0 top-0 flex h-10 w-10 items-center justify-center text-zinc-400 transition hover:text-zinc-900 focus:outline-none"
                            >
                                <i x-show="!show" data-lucide="eye"
                                   class="h-4 w-4"></i>

                                <i x-show="show" x-cloak data-lucide="eye-off"
                                   class="h-4 w-4"></i>
                            </button>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="mt-2">
                        <x-button type="submit" title="Masuk" variant="primary" size="md" icon="log-in" class="w-full" />
                    </div>
                </form>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="mt-6 space-y-3 text-center">

            <p class="text-xs text-zinc-400">
                &copy; {{ date('Y') }} BKPSDM Majelengka. All rights reserved.
            </p>
        </div>

    </div>
</section>
@endsection
