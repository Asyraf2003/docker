<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="h-full scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ $title ?? __('messages.default_page_title') }}</title>
  <link rel="canonical" href="{{ url()->current() }}">
  <meta name="robots" content="index,follow,max-image-preview:large">
  <meta name="description" content="@yield('meta_description','Landing sederhana dengan Tailwind, cepat dan responsif.')">
  
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="{{ config('app.name') }}">
  <meta property="og:title" content="@yield('og_title', $title ?? config('app.name'))">
  <meta property="og:description" content="@yield('og_description','Landing sederhana dengan Tailwind, cepat dan responsif.')">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
  
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('twitter_title', $title ?? config('app.name'))">
  <meta name="twitter:description" content="@yield('twitter_desc','Landing sederhana dengan Tailwind, cepat dan responsif.')">
  <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-default.jpg'))">
  
  <link rel="icon" type="image/svg+xml" href="{{ asset('icons/favicon.svg') }}">
  <link rel="alternate icon" href="{{ asset('icons/favicon.ico') }}">
  <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}">
  <meta name="theme-color" content="#0ea5e9">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  @php
    $isProduction = app()->environment('production');
    $manifestPath = public_path('build/manifest.json');
  @endphp

  @if($isProduction && file_exists($manifestPath))
    @php
        $manifest = json_decode(file_get_contents($manifestPath), true);
    @endphp

    @foreach($manifest as $file)
        <link rel="stylesheet" href="{{ config('app.url') }}/build/{{ $manifest['resources/css/app.css']['file'] }}">
        <script type="module" src="{{ config('app.url') }}/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
    @endforeach
  @else
    @viteReactRefresh
    @vite(['resources/js/app.js', 'resources/css/app.css'])
  @endif
</head>

<body class="min-h-dvh bg-gray-50 text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100">
  {{-- HEADER --}}
  <header class="sticky top-0 z-40 backdrop-blur bg-white/70 dark:bg-gray-950/70 border-b border-gray-200/70 dark:border-gray-800/70 -mb-px">
    <div class="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">
        {{-- Brand --}}
        <a href="{{ url('/') }}" class="font-semibold tracking-tight" aria-label="Beranda {{ config('app.name') }}">
        {{ config('app.name') }}
        </a>

        {{-- NAV DESKTOP (Tailwind + Alpine untuk dropdown) --}}
        <nav aria-label="Navigasi utama" class="hidden md:flex items-center gap-6 text-sm">
        <ul class="flex items-center gap-6" x-data="{openEdu:false, openLang:false, openWhy:false}">
            {{-- 1. Home --}}
            <li>
            <a href="/" class="hover:opacity-80">
                {{ __('messages.nav_menu_satu') }}
            </a>
            </li>

            {{-- 2. About --}}
            <li>
            <a href="#about" class="hover:opacity-80">
                {{ __('messages.nav_menu_dua') }}
            </a>
            </li>

            {{-- 3. Articles --}}
            <li>
            <a href="#articles" class="hover:opacity-80">
                {{ __('messages.nav_menu_tiga') }}
            </a>
            </li>

            {{-- 4. Gallery --}}
            <li>
            <a href="#gallery" class="hover:opacity-80">
                {{ __('messages.nav_menu_empat') }}
            </a>
            </li>

            {{-- 5. Pendidikan (dropdown + subdropdown) --}}
            <li class="relative" @mouseenter="openEdu=true" @mouseleave="openEdu=false">
            <button type="button" class="inline-flex items-center gap-1 hover:opacity-80" :aria-expanded="openEdu">
                {{ __('messages.nav_menu_lima') }}
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
            </button>
            {{-- Panel dropdown --}}
            <div x-cloak x-show="openEdu" x-transition.opacity
                class="absolute left-0 mt-2 min-w-64 rounded-lg border border-gray-200/70 dark:border-gray-800/70 bg-white dark:bg-gray-950 shadow-lg p-2">
                <ul class="text-sm">
                <li>
                    <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    {{ __('messages.nav_menu_lima_dropdown_satu') }}
                    </a>
                </li>

                {{-- Submenu: Mitra Bahasa --}}
                <li class="relative" x-data="{openSub:false}" @mouseenter="openSub=true" @mouseleave="openSub=false">
                    <button type="button" class="w-full flex items-center justify-between rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    <span>{{ __('messages.nav_menu_lima_dropdown_dua') }}</span>
                    <svg class="h-4 w-4 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6"/></svg>
                    </button>
                    <div x-cloak x-show="openSub" x-transition.opacity
                        class="absolute top-0 left-full ml-2 min-w-56 rounded-lg border border-gray-200/70 dark:border-gray-800/70 bg-white dark:bg-gray-950 shadow-lg p-2">
                    <ul>
                        <li>
                        <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                            {{ __('messages.nav_menu_lima_dropdown_dua_dropdown_satu') }}
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                            {{ __('messages.nav_menu_lima_dropdown_dua_dropdown_dua') }}
                        </a>
                        </li>
                    </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    {{ __('messages.nav_menu_lima_dropdown_tiga') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    {{ __('messages.nav_menu_lima_dropdown_empat') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    {{ __('messages.nav_menu_lima_dropdown_lima') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    {{ __('messages.nav_menu_lima_dropdown_enam') }}
                    </a>
                </li>
                </ul>
            </div>
            </li>

            {{-- 6. Mengapa kami (dropdown) --}}
            <li class="relative" x-data @mouseenter="openWhy=true" @mouseleave="openWhy=false">
            <button type="button" class="inline-flex items-center gap-1 hover:opacity-80" :aria-expanded="openWhy">
                {{ __('messages.nav_menu_enam') }}
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
            </button>
            <div x-cloak x-show="openWhy" x-transition.opacity
                class="absolute left-0 mt-2 min-w-48 rounded-lg border border-gray-200/70 dark:border-gray-800/70 bg-white dark:bg-gray-950 shadow-lg p-2">
                <ul class="text-sm">
                <li>
                    <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    {{ __('messages.nav_menu_enam_dropdown_satu') }}
                    </a>
                </li>
                </ul>
            </div>
            </li>

            {{-- 7. Contact --}}
            <li>
            <a href="#contact" class="hover:opacity-80">
                {{ __('messages.nav_menu_tujuh') }}
            </a>
            </li>

            {{-- 8. Bahasa (dropdown) --}}
            <li class="relative" @mouseenter="openLang=true" @mouseleave="openLang=false">
            <button type="button" class="inline-flex items-center gap-1 hover:opacity-80" :aria-expanded="openLang">
                {{ __('messages.nav_menu_delapan') }}
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
            </button>
            <div x-cloak x-show="openLang" x-transition.opacity
                class="absolute left-0 mt-2 min-w-40 rounded-lg border border-gray-200/70 dark:border-gray-800/70 bg-white dark:bg-gray-950 shadow-lg p-2">
                <ul class="text-sm">
                <li>
                    <a href="{{ route('lang.switch', ['locale' => 'id']) }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    {{ __('messages.nav_menu_delapan_dropdown_satu') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    {{ __('messages.nav_menu_delapan_dropdown_dua') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('lang.switch', ['locale' => 'ar']) }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                    {{ __('messages.nav_menu_delapan_dropdown_tiga') }}
                    </a>
                </li>
                </ul>
            </div>
            </li>
        </ul>
        </nav>

        {{-- Right actions (Tema + Auth) --}}
        <div class="hidden md:flex items-center gap-2">
        <button id="theme-toggle" class="rounded-lg border px-3 py-1.5 text-sm focus:outline-none focus-visible:ring border-gray-200/70 dark:border-gray-800/70">
            {{ __('messages.nav_menu_sembilan') }}
        </button>

        {{-- AUTH (base function dipertahankan) --}}
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-2">
            @auth
                <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">{{ __('messages.nav_menu_duabelas') }}</a>
            @else
                <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">{{ __('messages.nav_menu_sepuluh') }}</a>
            @endauth
            </nav>
        @endif
        </div>

        {{-- Mobile: hamburger --}}
        <button id="nav-toggle" class="md:hidden inline-flex items-center justify-center rounded-md border px-3 py-1.5 text-sm border-gray-200/70 dark:border-gray-800/70" aria-controls="mobile-menu" aria-expanded="false">
        Menu
        </button>
    </div>

    {{-- MOBILE MENU (accordion sederhana dengan Alpine) --}}
    <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200/70 dark:border-gray-800/70">
        <nav class="px-4 py-3 grid gap-2 text-sm" aria-label="Navigasi utama seluler" x-data="{mEdu:false, mLang:false, mWhy:false, mSub:false}">
        <a href="{{ route('login') }}" class="py-1.5">{{ __('messages.nav_menu_satu') }}</a>
        <a href="#about" class="py-1.5">{{ __('messages.nav_menu_dua') }}</a>
        <a href="#articles" class="py-1.5">{{ __('messages.nav_menu_tiga') }}</a>
        <a href="#gallery" class="py-1.5">{{ __('messages.nav_menu_empat') }}</a>

        {{-- Pendidikan --}}
        <button type="button" @click="mEdu=!mEdu" class="flex w-full items-center justify-between py-1.5">
            <span>{{ __('messages.nav_menu_lima') }}</span>
            <svg class="h-4 w-4" :class="{'rotate-180':mEdu}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
        </button>
        <div x-cloak x-show="mEdu" class="ml-3 grid gap-1.5">
            <a href="{{ route('login') }}" class="py-1.5">{{ __('messages.nav_menu_lima_dropdown_satu') }}</a>

            {{-- Sub: Mitra Bahasa --}}
            <button type="button" @click="mSub=!mSub" class="flex w-full items-center justify-between py-1.5">
            <span>{{ __('messages.nav_menu_lima_dropdown_dua') }}</span>
            <svg class="h-4 w-4" :class="{'rotate-180':mSub}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
            </button>
            <div x-cloak x-show="mSub" class="ml-3 grid gap-1.5">
            <a href="{{ route('login') }}" class="py-1.5">{{ __('messages.nav_menu_lima_dropdown_dua_dropdown_satu') }}</a>
            <a href="{{ route('login') }}" class="py-1.5">{{ __('messages.nav_menu_lima_dropdown_dua_dropdown_dua') }}</a>
            </div>

            <a href="{{ route('login') }}" class="py-1.5">{{ __('messages.nav_menu_lima_dropdown_tiga') }}</a>
            <a href="{{ route('login') }}" class="py-1.5">{{ __('messages.nav_menu_lima_dropdown_empat') }}</a>
            <a href="{{ route('login') }}" class="py-1.5">{{ __('messages.nav_menu_lima_dropdown_lima') }}</a>
            <a href="{{ route('login') }}" class="py-1.5">{{ __('messages.nav_menu_lima_dropdown_enam') }}</a>
        </div>

        {{-- Mengapa kami --}}
        <button type="button" @click="mWhy=!mWhy" class="flex w-full items-center justify-between py-1.5">
            <span>{{ __('messages.nav_menu_enam') }}</span>
            <svg class="h-4 w-4" :class="{'rotate-180':mWhy}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
        </button>
        <div x-cloak x-show="mWhy" class="ml-3 grid gap-1.5">
            <a href="{{ route('login') }}" class="py-1.5">{{ __('messages.nav_menu_enam_dropdown_satu') }}</a>
        </div>

        <a href="#contact" class="py-1.5">{{ __('messages.nav_menu_tujuh') }}</a>

        {{-- Bahasa --}}
        <button type="button" @click="mLang=!mLang" class="flex w-full items-center justify-between py-1.5">
          <span>{{ __('messages.nav_menu_delapan') }}</span>
          <svg class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180':mLang}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
          </svg>
        </button>

        <div x-cloak x-show="mLang" class="ml-3 grid gap-1.5">
          <a href="{{ route('lang.switch', ['locale' => 'id']) }}" class="py-1.5">
            {{ __('messages.nav_menu_delapan_dropdown_satu') }}
          </a>
          <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="py-1.5">
            {{ __('messages.nav_menu_delapan_dropdown_dua') }}
          </a>
          <a href="{{ route('lang.switch', ['locale' => 'ar']) }}" class="py-1.5">
            {{ __('messages.nav_menu_delapan_dropdown_tiga') }}
          </a>
        </div>

        {{-- Tema + Auth (mobile) --}}
        <div class="flex items-center gap-2 pt-2">
            <button id="theme-toggle-mobile" class="rounded-lg border px-3 py-1.5 text-sm focus:outline-none focus-visible:ring border-gray-200/70 dark:border-gray-800/70">
                {{ __('messages.nav_menu_sembilan') }}
            </button>
            @if (Route::has('login'))
            <div class="ml-auto flex items-center gap-2">
                @auth
                <a href="{{ url('/dashboard') }}" class="inline-block px-4 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">{{ __('messages.nav_menu_duabelas') }}</a>
                @else
                <a href="{{ route('login') }}" class="inline-block px-4 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">{{ __('messages.nav_menu_sepuluh') }}</a>
                @endauth
            </div>
            @endif
        </div>
        </nav>
    </div>
  </header>

  <main id="main" role="main" class="px-4">
    {{ $slot }}
  </main>

  {{-- FOOTER --}}
  <footer role="contentinfo" class="mt-24 border-t dark:border-gray-800">
    <div class="max-w-6xl mx-auto px-4 h-16 text-sm flex items-center justify-between">
      <span>&copy; {{ date('Y') }} {{ config('app.name') }}</span>
      <a href="{{ url('/kebijakan-privasi') }}" class="hover:opacity-80">Privasi</a>
    </div>
  </footer>
</body>

</html>
