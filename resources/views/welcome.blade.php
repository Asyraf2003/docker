<x-page.index :title="$title ?? __('messages.default_page_title')">

  <section id="beranda"
      x-data="heroSlider"
      x-init="init()"
      aria-labelledby="hero-title"
      class="relative full-bleed min-h-[100svh] flex items-center overflow-hidden isolate -mt-px scroll-mt-16">

    <div class="absolute inset-0 -z-10">
      <template x-for="(img, i) in images" :key="i">
        <img :src="img" alt=""
            class="absolute inset-0 h-full w-full object-cover fade-soft"
            x-show="current === i"
            x-transition.opacity
            x-cloak
            loading="lazy"
            aria-hidden="true">
      </template>
      <div class="pointer-events-none absolute inset-0 bg-gradient-to-tr from-black/55 via-black/25 to-transparent"></div>
    </div>

    <div class="relative w-full max-w-6xl mx-auto grid gap-10 md:grid-cols-2 items-center px-6 sm:px-10">
      <div>
        <h1 id="hero-title" class="text-4xl md:text-5xl font-bold leading-tight text-white drop-shadow-sm">
          {{ __('messages.default_page_description') }}
        </h1>
        <p class="mt-3 max-w-prose text-white/90">
          {{ __('messages.default_page_description2') }}
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
          <a href="#articles" class="rounded-xl bg-sky-500/95 px-4 py-2 text-white hover:bg-sky-600 focus-visible:ring focus-visible:ring-white/50">{{ __('messages.default_page_artikel') }}</a>
          <a href="{{ route('ppdb.create') }}" class="rounded-xl border border-white/60 px-4 py-2 text-white hover:bg-white/10 focus-visible:ring focus-visible:ring-white/50">{{ __('messages.default_page_registerschool') }}</a>
        </div>

      </div>
    </div>
    <div class="pointer-events-none absolute inset-x-0 bottom-6 z-10 flex justify-center">
      <div class="pointer-events-auto flex items-center gap-2">
        <template x-for="(img, i) in images" :key="'dot-'+i">
          <button
            class="h-12 w-12 rounded-full ring-1 ring-white/50 transition"
            :class="current===i ? 'bg-white' : 'bg-white/40 hover:bg-white/60'"
            @click="go(i)"
            :aria-current="current===i"
            :aria-label="`Slide ${i+1}`">
          </button>
        </template>
      </div>
    </div>
  </section>

  <div class="max-w-7xl mx-auto">

    <section id="about" aria-labelledby="tentang-title" class="mt-20 scroll-mt-16">
      <h2 id="tentang-title" class="text-3xl font-semibold">
        {{ __('messages.about_title') }}
      </h2>
      <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-300 mx-auto">
        {{ __('messages.about_paragraph1') }}
      </p>

      <div class="mt-12 grid md:grid-cols-2 gap-8 items-start">
        {{-- Visi --}}
        <div class="relative w-full h-auto group">
            <div class="absolute inset-0 rounded-2xl bg-gray-200 dark:bg-gray-800 transition-all duration-300 ease-in-out transform translate-x-3 translate-y-3 group-hover:translate-x-6 group-hover:translate-y-6"></div>

            <div class="relative rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-200 dark:border-gray-700 shadow-md transition-all duration-300 ease-in-out transform group-hover:-translate-x-1 group-hover:-translate-y-1 hover:shadow-xl hover:border-indigo-300 dark:hover:border-indigo-600">
                <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">
                    {{ __('messages.about_vision_title') }}
                </h3>
                <p class="mt-3 text-gray-700 dark:text-gray-300 leading-relaxed">
                    {!! __('messages.about_vision_content') !!}
                </p>
            </div>
        </div>

        {{-- Misi --}}
        <div class="relative w-full h-auto group">
            <div class="absolute inset-0 rounded-2xl bg-gray-200 dark:bg-gray-800 transition-all duration-300 ease-in-out transform translate-x-3 translate-y-3 group-hover:translate-x-6 group-hover:translate-y-6"></div>

            <div class="relative rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-200 dark:border-gray-700 shadow-md transition-all duration-300 ease-in-out transform group-hover:-translate-x-1 group-hover:-translate-y-1 hover:shadow-2xl hover:border-indigo-300 dark:hover:border-indigo-600">
                <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">
                    {{ __('messages.about_mission_title') }}
                </h3>
                <ul class="mt-3 list-none space-y-3 text-gray-700 dark:text-gray-300 text-left">
                    <li class="flex items-start gap-2">
                        <span>{{ __('messages.about_mission_item1') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span>{{ __('messages.about_mission_item2') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span>{{ __('messages.about_mission_item3') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span>{{ __('messages.about_mission_item4') }}</span>
                    </li>
                </ul>
            </div>
        </div>
      </div>
    </section>

    <section id="nilai" aria-labelledby="nilai-title" class="mt-20 scroll-mt-16">
      <h2 id="nilai-title" class="text-3xl font-semibold">
        {{ __('messages.values_title') }}
        <!-- {{ __('messages.subsection1') }} -->
      </h2>
      <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-300 mx-auto">
        <!-- {{ __('messages.about_subsection1') }} -->
        {{ __('messages.values_description') }}
      </p>

      @php $values = config('ui.values', []); @endphp

      <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($values as $v)
          <div
            class="group rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-8
                  shadow-[0_6px_24px_rgba(0,0,0,0.08)] dark:shadow-[0_6px_24px_rgba(0,0,0,0.35)]
                  text-center transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl">
            <x-dynamic-component :component="'icons.' . $v['svg']"
                     class="mx-auto w-[100px] h-[100px] {{ $v['icon_color'] }}" />
            <h3 class="mt-4 text-3xl font-semibold {{ $v['text_color'] }}">
              {{ __($v['label_key']) }}
            </h3>
          </div>
        @endforeach
      </div>
    </section>

    <section id="fitur" aria-labelledby="fitur-title" class="mt-20 scroll-mt-16">
      <h2 id="fitur-title" class="text-3xl font-semibold">
        {{ __('messages.subsection1') }}
      </h2>
      <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-300 mx-auto">
        {{ __('messages.about_subsection1') }}
      </p>

      <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @foreach (__('messages.default_page_future') as $f)
            <div
              class="group relative overflow-hidden rounded-2xl bg-white dark:bg-gray-900 p-6 shadow-md
                    card-border-effect">

              {{-- Icon bulat kecil --}}
              <div class="flex items-center justify-center w-12 h-12 rounded-full 
                          bg-gradient-to-r from-indigo-500 to-purple-500 
                          text-white shadow-md shadow-indigo-300/40 dark:shadow-indigo-900/40 mb-4">
                <i class="bi bi-star-fill text-lg"></i>
              </div>

              <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                {{ $f['title'] }}
              </h3>
              <p class="mt-3 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                {{ $f['desc'] }}
              </p>
            </div>
        @endforeach
      </div>
    </section>

    <section id="gallery" aria-labelledby="galeri-title" class="mt-20 scroll-mt-16"
         x-data="galleryLightbox({{ Js::from(
            $gallery->map(function($img){
                // locale-aware fields
                $locMap = ['id'=>'id','en'=>'en','ar'=>'ar'];
                $suf = $locMap[app()->getLocale()] ?? 'id';
                $title = $img->{'title_'.$suf} ?: $img->title_id;
                $desc  = $img->{'description_'.$suf} ?: $img->description_id;

                // robust image url
                $p = $img->image_path;
                if (\Illuminate\Support\Str::startsWith($p, ['http://','https://'])) {
                    $imgUrl = $p;
                } elseif (\Illuminate\Support\Str::startsWith($p, ['storage/', 'gallery/', 'galery/'])) {
                    $imgUrl = \Illuminate\Support\Facades\Storage::url($p);
                } else {
                    $imgUrl = asset($p);
                }

                return [
                    'src'   => $imgUrl,
                    'title' => $title,
                    'desc'  => $desc,
                    'link'  => $img->link_url ?? null,
                ];
            })
         ) }})"
         @keydown.window.escape="close()"
         @keydown.window="onKeydown($event)">

      <h2 id="gallery-title" class="text-3xl font-semibold">
        {{ __('messages.gallery_title') }}
      </h2>
      <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-300 mx-auto">
        {{ __('messages.gallery_description') }}
      </p>
      <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
        @foreach ($gallery as $i => $img)
          @php
            $locMap = ['id' => 'id', 'en' => 'en', 'ar' => 'ar'];
            $suf    = $locMap[app()->getLocale()] ?? 'id';
            $title  = $img->{'title_'.$suf} ?: $img->title_id;
            $desc   = $img->{'description_'.$suf} ?: $img->description_id;

            $p = $img->image_path;
            if (\Illuminate\Support\Str::startsWith($p, ['http://','https://'])) {
                $imgUrl = $p;
            } elseif (\Illuminate\Support\Str::startsWith($p, ['storage/', 'gallery/', 'galery/'])) {
                $imgUrl = \Illuminate\Support\Facades\Storage::url($p);
            } else {
                $imgUrl = asset($p);
            }
          @endphp

          <figure class="group relative overflow-hidden rounded-lg bg-gray-200/60 dark:bg-gray-800 cursor-pointer"
                  @click="open({{ $i }})">
            <img
              src="{{ $imgUrl }}"
              alt="{{ $title }}"
              loading="lazy"
              class="aspect-video w-full object-cover transition-transform duration-300 group-hover:scale-105"
            />
            <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-2 sm:p-3 text-white">
              <div class="text-xs sm:text-sm font-medium truncate">{{ $title }}</div>
              @if ($desc)
                <div class="mt-0.5 text-[11px] sm:text-xs opacity-90 line-clamp-2">{{ $desc }}</div>
              @endif
            </figcaption>
          </figure>
        @endforeach
      </div>

      {{-- LIGHTBOX / MODAL --}}
      <div x-cloak x-show="isOpen"
          x-transition.opacity
          class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4"
          @click.self="close()">
        <div class="relative w-full max-w-5xl">
          {{-- Close button --}}
          <button @click="close()"
                  class="absolute -top-10 right-0 md:-top-12 text-white/90 hover:text-white text-2xl"
                  aria-label="Tutup">&times;</button>

          {{-- Image --}}
          <img :src="current.src" :alt="current.title"
              class="w-full max-h-[80vh] object-contain rounded-lg shadow-xl select-none"
              draggable="false" />

          {{-- Caption & CTA --}}
          <div class="mt-4 text-center text-white">
            <h3 class="text-lg font-semibold" x-text="current.title"></h3>
            <p class="mt-1 text-sm opacity-90" x-text="current.desc"></p>

            <template x-if="current.link">
              <a :href="current.link" target="_blank" rel="noopener"
                class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm">
                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path d="M12.586 3H17a1 1 0 011 1v4.414a1 1 0 11-2 0V6.414l-6.293 6.293a1 1 0 01-1.414-1.414L14.586 5H12.586a1 1 0 110-2z"/><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 112 0v3a4 4 0 01-4 4H5a4 4 0 01-4-4V7a4 4 0 014-4h3a1 1 0 110 2H5z"/></svg>
                {{ __('messages.gallery_link') }}
              </a>
            </template>
          </div>

          {{-- Prev / Next --}}
          <button @click.stop="prev()"
            class="absolute left-2 top-1/2 -translate-y-1/2 
                  h-12 w-12 p-4 rounded-full 
                  bg-white/20 backdrop-blur-sm 
                  text-black dark:text-white 
                  shadow-lg hover:shadow-xl 
                  hover:bg-white/40 dark:hover:bg-gray-700/50 
                  transition-all duration-300 ease-in-out 
                  hover:scale-110">
            ⬅️
          </button>
          <button @click.stop="prev()"
            class="absolute right-2 top-1/2 -translate-y-1/2 
                  h-12 w-12 rounded-full 
                  bg-white/20 backdrop-blur-sm 
                  text-black dark:text-white 
                  shadow-lg hover:shadow-xl 
                  hover:bg-white/40 dark:hover:bg-gray-700/50 
                  transition-all duration-300 ease-in-out 
                  hover:scale-110">
            ➡️
          </button>
        </div>
      </div>
    </section>
  
    <section id="pengumuman" aria-labelledby="pengumuman-title" class="mt-20 scroll-mt-16">
      <h2 id="pengunguman-title" class="text-3xl font-semibold">
          {{ __('messages.announcement_title') }}
      </h2>
      <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-300 mx-auto">
          {{ __('messages.announcement_description') }}
      </p>

      <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          @forelse ($announcements as $a)
              <article class="static-border-effect rounded-lg bg-white dark:bg-gray-900 p-4">
                  <div class="text-xs text-gray-500 dark:text-gray-400">
                      {{ optional($a->event_date)->translatedFormat('d M Y') }}
                  </div>

                  <h3 class="mt-1 font-medium">{{ $a->titleFor(app()->getLocale()) }}</h3>

                  @php $desc = $a->descFor(app()->getLocale()); @endphp
                  @if ($desc)
                      <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-3">{!! e($desc) !!}</p>
                  @endif

                  @if ($a->link_url)
                      <div class="mt-3">
                          <a href="{{ $a->link_url }}"
                            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                              {{ __('messages.more_announcement') }} →
                          </a>
                      </div>
                  @endif
              </article>
          @empty
              <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada pengumuman.</p>
          @endforelse
      </div>
    </section>

    <section id="informasi" class="mt-20 scroll-mt-16 bg-gray-50 dark:bg-gray-950 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
                {{ __('messages.stats_title') }}
            </h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300 max-w-2xl">
                {{ __('messages.stats_description') }}
            </p>

            <div class="mt-12 grid gap-12 lg:grid-cols-2 items-center">
                {{-- Kolom Kiri: Informasi dan Statistik --}}
                <div>
                    <h3 class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400">
                        {{ __('messages.stats_heading') }}
                    </h3>
                    <p class="mt-4 text-base text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ __('messages.stats_heading_description') }}
                    </p>

                    <div class="mt-8 grid grid-cols-2 gap-6 md:grid-cols-2">
                        {{-- Statistik Item 1 --}}
                        <div class="p-4 bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-800">
                            <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">41</p>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ __('messages.stats_students_description') }}</p>
                        </div>
                        {{-- Statistik Item 2 --}}
                        <div class="p-4 bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-800">
                            <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">12</p>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ __('messages.stats_awards_description') }}</p>
                        </div>
                        {{-- Statistik Item 3 --}}
                        <div class="p-4 bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-800">
                            <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">11</p>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ __('messages.stats_classes_description') }}</p>
                        </div>
                        {{-- Statistik Item 4 --}}
                        <div class="p-4 bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-800">
                            <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">7</p>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ __('messages.stats_curricular_description') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Foto Sekolah dengan Efek --}}
                <div class="relative w-full h-80 lg:h-96 group">
                    {{-- Kotak Bayangan --}}
                    <div class="absolute inset-0 rounded-2xl bg-gray-200 dark:bg-gray-800 transition-all duration-300 ease-in-out transform translate-x-3 translate-y-3 group-hover:translate-x-6 group-hover:translate-y-6"></div>
                    
                    {{-- Kotak Foto Asli --}}
                    <div class="relative inset-0 rounded-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-800 transition-all duration-300 ease-in-out transform group-hover:-translate-x-1 group-hover:-translate-y-1">
                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max" 
                            alt="Foto Gedung Sekolah" 
                            class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="program-unggulan" aria-labelledby="program-unggulan-title" class="mt-20 scroll-mt-16">
      <h2 id="program-unggulan-title" class="text-3xl font-semibold">
        {{ __('messages.flagship_programs') }}
      </h2>
      <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-300 mx-auto">
        {{ __('messages.flagship_programs_description') }}
      </p>

      <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @forelse ($programs as $p)
          <div class="rounded-lg border border-gray-200/70 dark:border-gray-800 bg-white dark:bg-gray-900 p-4">
            <h3 class="font-medium">{{ $p->titleFor(app()->getLocale()) }}</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
              {{ $p->descFor(app()->getLocale()) }}
            </p>
          </div>
        @empty
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.flagship_programs_empty') }}</p>
        @endforelse
      </div>
    </section>

    <section id="ekstrakurikuler" aria-labelledby="ekstra-title" class="mt-20 scroll-mt-16">
      <h2 id="ekstrakurikuler-title" class="text-3xl font-semibold">
        {{ __('messages.extracurricular_title') }}
      </h2>
      <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-300 mx-auto">
        {{ __('messages.extracurricular_description') }}
      </p>

      <div class="mt-6 flex flex-wrap gap-2">
        @forelse ($ekstra as $e)
          <span class="px-3 py-1 rounded-full text-sm bg-gray-200/70 dark:bg-gray-800 text-gray-800 dark:text-gray-100">
            {{ $e->nameFor(app()->getLocale()) }}
          </span>
        @empty
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.extracurricular_description_empty') }}</p>
        @endforelse
      </div>
    </section>

    <section id="agenda" aria-labelledby="agenda-title" class="mt-20 scroll-mt-16">
      <h2 id="agenda-title" class="text-3xl font-semibold">
        {{ __('messages.agenda_title') }}
      </h2>
      <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-300 mx-auto">
        {{ __('messages.agenda_description') }}
      </p>

      <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
        @forelse ($events as $ev)
          <div class="rounded-lg border border-gray-200/70 dark:border-gray-800 bg-white dark:bg-gray-900 p-4">
            <div class="text-xs text-gray-500 dark:text-gray-400">
              {{ optional($ev->event_date)->translatedFormat('l, d M Y • H:i') }}
              <span class="mx-2">•</span>
              {{ $ev->placeFor(app()->getLocale()) }}
            </div>
            <h3 class="mt-1 font-medium">{{ $ev->titleFor(app()->getLocale()) }}</h3>
            @if($ev->link_url)
              <div class="mt-3">
                <a href="{{ $ev->link_url }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                  {{ __('Detail agenda') }} →
                </a>
              </div>
            @endif
          </div>
        @empty
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.agenda_description_empty') }}</p>
        @endforelse
      </div>
    </section>
    
    <section id="articles" aria-labelledby="articles-title" class="mt-20 scroll-mt-16">
      <div class="flex items-center justify-between">
        <h2 id="articles-title" class="text-3xl font-semibold">
          {{ __('messages.articles_title') }}
        </h2>
        <a href="{{ route('articles.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('messages.articles_description') }}</a>
      </div>

      @php
        $loc = app()->getLocale();

        $articles = \App\Models\Article::published()
          ->with(['categories:id,slug,name_id,name_en,name_ar','tags:id,slug,name'])
          ->orderByDesc('published_at')
          ->take(6)
          ->get();

        $titleKey = fn($a) => "title_{$loc}";
        $excerptKey = fn($a) => "excerpt_{$loc}";

        $heroUrlFn = function (?string $p) {
            if (!$p) return null;
            if (\Illuminate\Support\Str::startsWith($p, ['http://','https://'])) return $p;
            if (\Illuminate\Support\Str::startsWith($p, ['storage/','article/','articles/'])) return \Illuminate\Support\Facades\Storage::url($p);
            return asset($p);
        };
      @endphp

      <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($articles as $a)
          @php
            $title = $a->{$titleKey($a)} ?: $a->title_id;
            $desc  = $a->{$excerptKey($a)} ?: $a->excerpt_id ?: \Illuminate\Support\Str::limit($a->meta_desc_id ?? '', 110);
            $date  = optional($a->published_at)->translatedFormat('d M Y');
            $hero  = $heroUrlFn($a->hero_image);
            $cats  = $a->categories->take(2);
            $tags  = $a->tags->take(2);
          @endphp

          <a href="{{ route('article', $a->slug) }}"
            class="group relative overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:shadow-md transition">

            {{-- Badge pojok kiri atas (opsional) --}}
            @if($a->is_hot || $a->is_featured)
              <div class="absolute left-3 top-3 z-10 flex gap-2">
                @if($a->is_hot)
                  <span class="text-[10px] uppercase tracking-wide px-2 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">Hot</span>
                @endif
                @if($a->is_featured)
                  <span class="text-[10px] uppercase tracking-wide px-2 py-1 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">Featured</span>
                @endif
              </div>
            @endif

            {{-- Gambar --}}
            <div class="aspect-video bg-gray-200/60 dark:bg-gray-800 overflow-hidden">
              @if($hero)
                <img src="{{ $hero }}" alt="{{ $title }}" loading="lazy"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
              @endif
            </div>

            {{-- Konten --}}
            <div class="p-4 space-y-2">
              <h3 class="font-semibold leading-snug line-clamp-2 group-hover:text-indigo-600">{{ $title }}</h3>

              {{-- Meta: tanggal + kategori/tag --}}
              <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                @if($date)
                  <time datetime="{{ $a->published_at->toDateString() }}">{{ $date }}</time>
                @endif>

                @foreach($cats as $c)
                  <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    {{ $c->{'name_'.$loc} ?: $c->name_id }}
                  </span>
                @endforeach

                @foreach($tags as $t)
                  <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">#{{ $t->name }}</span>
                @endforeach
              </div>

              {{-- Deskripsi singkat --}}
              @if($desc)
                <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $desc }}</p>
              @endif
            </div>
          </a>
        @empty
          {{-- Skeleton bila tidak ada data --}}
          @for ($i = 1; $i <= 6; $i++)
            <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 overflow-hidden">
              <div class="aspect-video bg-gray-200/60 dark:bg-gray-800"></div>
              <div class="p-4 space-y-2">
                <div class="h-4 w-3/4 bg-gray-200 dark:bg-gray-700 rounded"></div>
                <div class="h-3 w-1/3 bg-gray-200 dark:bg-gray-700 rounded"></div>
                <div class="h-3 w-2/3 bg-gray-200 dark:bg-gray-700 rounded"></div>
              </div>
            </div>
          @endfor
        @endforelse
      </div>
    </section>

    <section id="contact" aria-labelledby="kontak-title" class="mt-20 scroll-mt-16">
      <h2 id="contact-title" class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
        {{ __('messages.contact_title') }}
      </h2>
      <p class="mt-4 text-base sm:text-lg text-gray-600 dark:text-gray-300 mx-auto">
        {{ __('messages.contact_description') }}
      </p>

      <div class="mt-10 grid gap-10 lg:grid-cols-2">

        <div class="flex flex-col gap-8">
          <form class="space-y-4" action="{{ route('profile.edit') }}" method="POST" novalidate>
            @csrf
            <label class="block">
              <span class="sr-only">Nama</span>
              <input name="name" type="text" autocomplete="name" placeholder="Nama"
                    class="w-full rounded-xl border px-4 py-2 dark:border-gray-800 dark:bg-gray-900 focus:outline-none focus-visible:ring ring-indigo-500"
                    required aria-required="true">
            </label>
            <label class="block">
              <span class="sr-only">Email</span>
              <input name="email" type="email" autocomplete="email" placeholder="Email"
                    class="w-full rounded-xl border px-4 py-2 dark:border-gray-800 dark:bg-gray-900 focus:outline-none focus-visible:ring ring-indigo-500"
                    required>
            </label>
            <label class="block">
              <span class="sr-only">Pesan</span>
              <textarea name="message" rows="4" placeholder="Pesan"
                        class="w-full rounded-xl border px-4 py-2 dark:border-gray-800 dark:bg-gray-900 focus:outline-none focus-visible:ring ring-indigo-500"
                        required></textarea>
            </label>
            <button type="submit" class="rounded-xl bg-sky-500 px-6 py-2 text-white font-medium hover:bg-sky-600 focus-visible:ring ring-sky-500">
              {{ __('messages.footer_newsletter_button2') }}
            </button>
          </form>

          <div class="space-y-4 text-gray-600 dark:text-gray-400">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.contact_address') }}</h3>
            <p>{{ __('messages.contact_address_content') }}</p>
            <p>{{ __('messages.contact_phone_content') }}</p>
            <p>{{ __('messages.contact_email_content') }}</p>
          </div>
        </div>

        <div class="w-full h-80 lg:h-full rounded-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-800">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.392599291162!2d112.62112117555814!3d-7.9583173920663155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd629d615f95c25%3A0xb8e33f7ffdee9560!2sTPA%2C%20TPQ%2C%20KB%2C%20TK%20Al%20Mustaqbal!5e0!3m2!1sen!2sid!4v1758036205480!5m2!1sen!2sid" 
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            title="Lokasi Al-Mustaqbal di Google Maps"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>

      <hr class="my-16 border-gray-200 dark:border-gray-800">

      <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 text-center sm:text-left">
        <div>
          <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.footer_page') }}</h4>
          <div class="flex justify-center sm:justify-start gap-4 text-gray-600 dark:text-gray-400">
            <a href="#" class="hover:text-sky-500 transition-colors"><i class="fab fa-facebook-f"></i> Facebook</a>
            <a href="#" class="hover:text-sky-500 transition-colors"><i class="fab fa-twitter"></i> Twitter</a>
            <a href="#" class="hover:text-sky-500 transition-colors"><i class="fab fa-instagram"></i> Instagram</a>
          </div>
        </div>

        <div>
          <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.footer_label') }}</h4>
          <ul class="space-y-2 text-gray-600 dark:text-gray-400">
            <li><a href="#" class="hover:text-sky-500 transition-colors">{{ __('messages.footer_about') }}</a></li>
            <li><a href="#" class="hover:text-sky-500 transition-colors">{{ __('messages.footer_about2') }}</a></li>
            <li><a href="#" class="hover:text-sky-500 transition-colors">{{ __('messages.footer_about3') }}</a></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.footer_friend') }}</h4>
          <div class="flex justify-center sm:justify-start flex-wrap gap-4 text-gray-600 dark:text-gray-400">
            <a href="#" class="hover:text-sky-500 transition-colors">Mitra A</a>
            <a href="#" class="hover:text-sky-500 transition-colors">Mitra B</a>
          </div>
        </div>

        <div>
          <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.footer_newsletter') }}</h4>
          <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.footer_newsletter_desc') }}</p>
          <form class="mt-2 flex flex-col sm:flex-row gap-2">
            <input type="email" placeholder="Email Anda" class="rounded-xl border px-4 py-2 w-full dark:border-gray-800 dark:bg-gray-900 focus:outline-none focus-visible:ring ring-indigo-500">
            <button type="submit" class="rounded-xl bg-sky-500 px-4 py-2 text-white hover:bg-sky-600 focus-visible:ring ring-sky-500">
              {{ __('messages.footer_newsletter_button') }}
            </button>
          </form>
        </div>
      </div>
    </section>
  </div>
</x-page.index> 