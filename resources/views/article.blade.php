{{-- ===== Helpers & mode flags (top of file) ===== --}}
@php
  $loc = app()->getLocale();

  $heroUrl = function (?string $p) {
    if (!$p) return null;
    if (\Illuminate\Support\Str::startsWith($p, ['http://','https://'])) return $p;
    if (\Illuminate\Support\Str::startsWith($p, ['storage/','article/','articles/'])) {
      return \Illuminate\Support\Facades\Storage::url($p);
    }
    return asset($p);
  };
  $titleFor = fn($m) => $m?->{"title_{$loc}"} ?: ($m->title_id ?? '');
  $excerptFor = fn($m) => $m?->{"excerpt_{$loc}"} ?? ($m->excerpt_id ?? \Illuminate\Support\Str::limit($m->meta_desc_id ?? '', 110));

  $search   = request('q');
  $hasQuery = request()->filled('q') || request()->filled('category') || request()->filled('tag');
  $hasArticle = isset($article);

  $isDetail = $hasArticle && !$hasQuery;   // baca satu artikel
  $isSearch = !$hasArticle && $hasQuery;   // hasil pencarian / filter
  $isIndex  = !$hasArticle && !$hasQuery;  // beranda artikel (listing umum)
@endphp

<x-page.index :title="$isDetail ? $titleFor($article) : 'Artikel'">
  <div class="min-h-screen bg-white dark:bg-gray-950">
    {{-- ===== HERO STRIP: hanya pencarian selalu; elemen lain hanya di Index ===== --}}
    <section class="border-b border-gray-200/70 dark:border-gray-800/60">
      <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        {{-- Pencarian (selalu tampil) --}}
        <div class="flex items-center gap-3">
          <form action="{{ route('articles.index') }}" method="GET" class="flex-1 relative">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ __('messages.article_page_placeholder_search') }}"
              class="w-full rounded-2xl border border-gray-300 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1 rounded-xl bg-indigo-600 text-white text-sm">{{ __('messages.article_page_search_button') }}</button>
          </form>
          <a href="{{ route('articles.index') }}" class="hidden sm:inline-flex rounded-xl px-3 py-2 text-sm border border-gray-300 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900">
            {{ __('messages.article_page_show_all') }}
          </a>
        </div>

        @if($isIndex)
          {{-- Info Panas --}}
          @php
            $hotInfos = $hotInfos
              ?? \App\Models\HotInfo::activeNow()->limit(6)->get(['title_id','title_en','title_ar','url']);
            $titleKey = fn($m) => "title_{$loc}";
          @endphp
          @if($hotInfos->count())
            <div x-data="{i:0, items: {{ $hotInfos->map(fn($h)=>['title'=>$h->{$titleKey($h)} ?: $h->title_id, 'url'=>$h->url ?: route('articles.index')])->values()->toJson() }} }"
                 x-init="setInterval(()=>{ i=(i+1)%items.length }, 3500)"
                 class="rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 px-4 py-3 flex items-center gap-3">
              <span class="text-amber-700 dark:text-amber-300 text-sm font-semibold">{{ __('messages.article_page_hot_info') }}</span>
              <div class="h-6 relative overflow-hidden flex-1">
                <template x-for="(it,idx) in items" :key="idx">
                  <a :href="it.url"
                     class="absolute inset-0 flex items-center text-sm text-amber-900 dark:text-amber-200 transition-all duration-500"
                     :class="i===idx ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-3'">
                     <span x-text="it.title"></span>
                  </a>
                </template>
              </div>
            </div>
          @endif

          {{-- Kategori chips --}}
          @php
            $categoriesChip = $categoriesChip
              ?? \App\Models\Category::active()->ordered()->limit(12)->get(['id','slug','name_id','name_en','name_ar']);
          @endphp
          <div class="flex flex-wrap items-center gap-2">
            @foreach($categoriesChip as $c)
              <a href="{{ route('articles.index', ['category'=>$c->slug]) }}"
                 class="rounded-full border border-gray-300 dark:border-gray-800 px-3 py-1.5 text-sm hover:bg-gray-100 dark:hover:bg-gray-900">
                {{ $c->{"name_{$loc}"} ?: $c->name_id }}
              </a>
            @endforeach
          </div>

          {{-- Top News (3) --}}
          @php
            $topNews = ($topNews ?? null) ?: \App\Models\Article::top()->limit(3)->get();
          @endphp
          @if($topNews->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              @foreach($topNews as $t)
                @php $tTitle = $titleFor($t); @endphp
                <a href="{{ route('article', $t->slug) }}" class="group rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden hover:shadow-md transition">
                  <div class="aspect-[16/9] bg-gray-200 dark:bg-gray-800 overflow-hidden">
                    @if($heroUrl($t->hero_image))
                      <img src="{{ $heroUrl($t->hero_image) }}" alt="{{ $tTitle }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @endif
                  </div>
                  <div class="p-4 space-y-2">
                    <div class="text-xs text-gray-500 dark:text-gray-400">Top News</div>
                    <h3 class="font-semibold group-hover:text-indigo-600 line-clamp-2">{{ $tTitle }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $excerptFor($t) }}</p>
                  </div>
                </a>
              @endforeach
            </div>
          @endif
        @endif
      </div>
    </section>

    {{-- ===== BODY: 3 Kolom ===== --}}
    <section class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8 py-10">
      <div class="grid grid-cols-12 gap-6">

        {{-- LEFT SIDEBAR → sembunyikan saat search --}}
        @unless($isSearch)
          <aside class="hidden lg:block col-span-12 lg:col-span-2 space-y-6">
            @php $tagsPopular = \App\Models\Tag::popular()->limit(16)->get(); @endphp
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-4">
              <h4 class="font-semibold mb-3">{{ __('messages.article_page_populer_tag') }}</h4>
              <div class="flex flex-wrap gap-2">
                @foreach($tagsPopular as $t)
                  <a href="{{ route('articles.index', ['tag'=>$t->slug]) }}" class="text-xs rounded-full bg-gray-100 dark:bg-gray-900 px-3 py-1 border border-gray-200 dark:border-gray-800 hover:bg-gray-200 dark:hover:bg-gray-800">#{{ $t->name }}</a>
                @endforeach
              </div>
            </div>
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-4">
              <h4 class="font-semibold mb-2">{{ __('messages.article_page_newsletter') }}</h4>
              <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">{{ __('messages.article_page_newsletter_desc') }}</p>
              <form action="#" class="space-y-2">
                @csrf
                <input class="w-full rounded-xl border border-gray-300 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 px-3 py-2" placeholder="{{ __('messages.article_page_newsletter_placeholder') }}">
                <button class="w-full rounded-xl bg-indigo-600 text-white px-3 py-2">{{ __('messages.article_page_newsletter_desc2') }}</button>
              </form>
            </div>
          </aside>
        @endunless

        <main class="col-span-12 lg:col-span-7 space-y-8">
          @if($isDetail)
            {{-- ========== MODE DETAIL (Baca satu artikel) ========== --}}
            <nav class="text-sm text-gray-500 dark:text-gray-400">
              <a href="{{ url('/') }}" class="hover:text-indigo-600">{{ __('messages.article_page_home') }}</a> /
              <a href="{{ route('articles.index') }}" class="hover:text-indigo-600">{{ __('messages.article_page_article') }}</a> /
              <span>{{ $titleFor($article) }}</span>
            </nav>

            @php
              $aTitle = $titleFor($article);
              $aHero  = $heroUrl($article->hero_image);
              $aDate  = optional($article->published_at)->translatedFormat('d M Y');
            @endphp

            <article class="space-y-4">
              <h1 class="text-2xl sm:text-3xl font-bold leading-tight">
                <a href="{{ route('article', $article->slug) }}" class="hover:text-indigo-600">{{ $aTitle }}</a>
              </h1>
              <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                @if($article->author)
                  <img src="https://placehold.co/40x40" class="h-8 w-8 rounded-full" alt="{{ $article->author->name }}">
                  <span>{{ __('messages.article_by') }} <span class="font-medium">{{ $article->author->name }}</span></span>
                  <span>•</span>
                @endif
                @if($aDate)
                  <time datetime="{{ $article->published_at->toDateString() }}">{{ $aDate }}</time>
                  <span>•</span>
                @endif
                @if($article->reading_time)
                  <span>{{ $article->reading_time }} {{ __('messages.article_time') }}</span>
                @endif
              </div>

              @if($aHero)
                <figure class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-800">
                  <img src="{{ $aHero }}" alt="{{ $aTitle }}" class="w-full">
                </figure>
              @endif

              <div class="prose prose-indigo dark:prose-invert max-w-none">
                @foreach($article->sections as $sec)
                  @switch($sec->type)
                    @case('quote')
                      <blockquote>{{ $sec->bodyFor($loc) }}</blockquote>
                      @break
                    @case('image_only')
                      @php $secUrl = $heroUrl($sec->image_path); @endphp
                      @if($secUrl)
                        <figure>
                          <img src="{{ $secUrl }}" alt="{{ $sec->imageAltFor($loc) }}">
                          @if($sec->imageAltFor($loc))
                            <figcaption class="text-sm text-gray-500">{{ $sec->imageAltFor($loc) }}</figcaption>
                          @endif
                        </figure>
                      @endif
                      @break
                    @case('embed')
                      {!! $sec->bodyFor($loc) !!}
                      @break
                    @default
                      {!! nl2br(e($sec->bodyFor($loc))) !!}
                  @endswitch
                @endforeach
              </div>
            </article>

            {{-- Komentar --}}
            <section id="comments" class="space-y-4">
              {{-- Flash message & errors (opsional, tampilkan di tempat global kalau sudah ada) --}}
              @if (session('success'))
                <div class="rounded-xl bg-green-50 text-green-700 px-4 py-3 border border-green-200">
                  {{ session('success') }}
                </div>
              @endif
              @if ($errors->any())
                <div class="rounded-xl bg-red-50 text-red-700 px-4 py-3 border border-red-200">
                  <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $e)
                      <li>{{ $e }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <h2 class="text-lg font-semibold">
                {{ __('messages.article_comment') }} ({{ $article->comment_count }})
              </h2>

              <form action="{{ route('comments.store', $article->id) }}" method="POST" class="space-y-3">
                @csrf

                {{-- Hidden parent_id kalau sedang membalas --}}
                @isset($replyTo)
                  <input type="hidden" name="parent_id" value="{{ $replyTo->id }}">
                @endisset
                {{-- Honeypot: SELALU ada (bukan hanya saat reply) --}}
                <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

                @guest
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input
                      name="guest_name"
                      value="{{ old('guest_name') }}"
                      class="rounded-xl border border-gray-300 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 px-3 py-2"
                      placeholder="{{ __('messages.article_comment_name') }}"
                      required
                    >
                    <input
                      name="guest_email"
                      value="{{ old('guest_email') }}"
                      class="rounded-xl border border-gray-300 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 px-3 py-2"
                      placeholder="{{ __('messages.article_comment_email') }}"
                      type="email"
                      required
                    >
                  </div>
                @endguest
                @isset($replyTo)
                  <div class="rounded-lg border border-indigo-200 dark:border-indigo-900 bg-indigo-50/50 dark:bg-indigo-900/30 px-3 py-2 text-sm mb-1">
                    <div class="font-medium">
                      Membalas: {{ $replyTo->user->name ?? $replyTo->guest_name ?? 'Pengguna' }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-300 line-clamp-2">
                      {{ Str::limit($replyTo->body, 140) }}
                    </div>
                  </div>
                @endisset
                <textarea
                  name="body"
                  class="w-full rounded-xl border border-gray-300 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 px-3 py-2"
                  rows="3"
                  placeholder="{{ __('messages.article_write_comment') }}"
                  required>{{ old('body') }}</textarea>

                <div class="flex items-center gap-3">
                  <button class="rounded-xl bg-indigo-600 text-white px-4 py-2">
                    {{ __('messages.article_send_comment') }}
                  </button>

                  @isset($replyTo)
                    <a
                      href="{{ route('article', ['slug' => $article->slug]) }}#comments"
                      class="text-sm text-gray-600 dark:text-gray-300 hover:underline"
                    >Batal balas</a>
                  @endisset
                </div>
              </form>

              @php
                // Ambil semua komentar approved (hindari N+1)
                $all = $article->comments()->approved()->with('user')->oldest()->get();
                $grouped  = $all->groupBy('parent_id');
                $topLevel = $grouped[null] ?? collect();
              @endphp

              <div class="space-y-3">
                @forelse($topLevel as $c)
                  @include('components.partials.comment-item', [
                    'c' => $c,
                    'grouped' => $grouped,
                    'article' => $article,
                    'level' => 0,
                    'replyToId' => request('reply_to')
                  ])
                @empty
                  <p class="text-sm text-gray-500">{{ __('messages.article_comment_empty') }}</p>
                @endforelse
              </div>
            </section>

            {{-- Sorotan (featured) --}}
            @if(($featured ?? collect())->count())
              <section class="space-y-3">
                <h2 class="text-lg font-semibold">{{ __('messages.article_trend') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  @foreach($featured as $f)
                    @php $fTitle = $titleFor($f); @endphp
                    <a href="{{ route('article', $f->slug) }}" class="group rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden hover:shadow-md transition">
                      <div class="aspect-[16/9] bg-gray-200 dark:bg-gray-800 overflow-hidden">
                        @if($heroUrl($f->hero_image))
                          <img src="{{ $heroUrl($f->hero_image) }}" alt="{{ $fTitle }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @endif
                      </div>
                      <div class="p-4">
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.article_trend2') }}</div>
                        <h3 class="font-semibold group-hover:text-indigo-600 line-clamp-2">{{ $fTitle }}</h3>
                      </div>
                    </a>
                  @endforeach
                </div>
              </section>
            @endif

          @else
            {{-- ========== MODE LISTING (Index & Search) ========== --}}
            <div class="flex items-center justify-between mb-4">
              <h1 class="text-2xl font-bold">
                @if($isSearch) {{ __('messages.article_search_main') }} “{{ $search }}” @else {{ __('messages.article_page_article') }} @endif
              </h1>
              @isset($articles)
                <span class="text-sm text-gray-500">{{ $articles->total() }} {{ __('messages.article_search_main2') }}</span>
              @endisset
            </div>

            @isset($articles)
              @if($articles->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                  @foreach($articles as $a)
                    @php
                      $tTitle = $titleFor($a);
                      $tDesc  = $excerptFor($a);
                      $tImg   = $heroUrl($a->hero_image);
                      $date   = optional($a->published_at)->translatedFormat('d M Y');
                      $cats   = $a->categories->take(2);
                    @endphp
                    <a href="{{ route('article', $a->slug) }}"
                       class="group rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden hover:shadow-md transition bg-white dark:bg-gray-900">
                      <div class="aspect-[16/9] bg-gray-200 dark:bg-gray-800 overflow-hidden">
                        @if($tImg)
                          <img src="{{ $tImg }}" alt="{{ $tTitle }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @endif
                      </div>
                      <div class="p-4 space-y-2">
                        <div class="flex flex-wrap gap-2 text-xs text-gray-500 dark:text-gray-400">
                          @foreach($cats as $c)
                            <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                              {{ $c->{"name_{$loc}"} ?: $c->name_id }}
                            </span>
                          @endforeach
                        </div>
                        <h3 class="font-semibold leading-snug line-clamp-2 group-hover:text-indigo-600">{{ $tTitle }}</h3>
                        @if($tDesc)
                          <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $tDesc }}</p>
                        @endif
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                          {{ $a->author->name ?? 'Admin' }}@if($date) • {{ $date }}@endif
                        </div>
                      </div>
                    </a>
                  @endforeach
                </div>

                <div class="mt-6">
                  {{ $articles->links() }}
                </div>
              @else
                <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-6 text-center">
                  <div class="text-lg font-semibold mb-1">{{ __('messages.article_search_main_empty') }}</div>
                  <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.article_search_main_empty_desc') }}
                    <a href="{{ route('articles.index') }}" class="text-indigo-600 hover:underline">{{ __('messages.article_search_main_empty_reset') }}</a>.
                  </p>
                </div>
              @endif
            @endisset
          @endif
        </main>

        {{-- RIGHT SIDEBAR → sembunyikan saat search --}}
        @unless($isSearch)
          <aside class="col-span-12 lg:col-span-3 space-y-6">
            @if(($top ?? collect())->count())
              <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-4">
                <h4 class="font-semibold mb-3">{{ __('messages.article_top_article') }}</h4>
                <div class="space-y-3">
                  @foreach($top as $t)
                    @php $tTitle = $titleFor($t); @endphp
                    <a href="{{ route('article', $t->slug) }}" class="flex gap-3 group">
                      <div class="h-16 w-24 bg-gray-200 dark:bg-gray-800 rounded-lg overflow-hidden">
                        @if($heroUrl($t->hero_image))
                          <img src="{{ $heroUrl($t->hero_image) }}" alt="{{ $tTitle }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @endif
                      </div>
                      <div class="flex-1">
                        <h5 class="text-sm font-semibold group-hover:text-indigo-600 leading-snug line-clamp-2">{{ $tTitle }}</h5>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($t->view_count) }} {{ __('messages.article_top_article_read') }} • {{ $t->comment_count }} {{ __('messages.article_top_article_comment') }}</div>
                      </div>
                    </a>
                  @endforeach
                </div>
              </div>
            @endif

            @php
              $subCats = \App\Models\Category::whereNotNull('parent_id')->active()
                ->withCount(['articles' => fn($q)=>$q->published()])
                ->ordered()->limit(8)->get();
            @endphp
            @if($subCats->count())
              <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-4">
                <h4 class="font-semibold mb-3">{{ __('messages.article_sub_category') }}</h4>
                <ul class="space-y-2 text-sm">
                  @foreach($subCats as $s)
                    <li>
                      <a href="{{ route('articles.index', ['category'=>$s->slug]) }}"
                         class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-900 border border-transparent hover:border-gray-200 dark:hover:border-gray-800">
                        <span>{{ $s->{"name_{$loc}"} ?: $s->name_id }}</span>
                        <span class="text-xs text-gray-500">{{ $s->articles_count }}</span>
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif
          </aside>
        @endunless
      </div>
    </section>

    {{-- ===== BOTTOM: Artikel Lainnya (hanya detail) ===== --}}
    @if($isDetail && ($related ?? collect())->count())
      <section class="border-t border-gray-200 dark:border-gray-800">
        <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8 py-10">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">{{ __('messages.article_any') }}</h2>
            <a href="{{ route('articles.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('messages.article_page_show_all') }}</a>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $r)
              @php $rTitle = $titleFor($r); @endphp
              <a href="{{ route('article', $r->slug) }}" class="group rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden hover:shadow-md transition">
                <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-800 overflow-hidden">
                  @if($heroUrl($r->hero_image))
                    <img src="{{ $heroUrl($r->hero_image) }}" alt="{{ $rTitle }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                  @endif
                </div>
                <div class="p-4 space-y-1.5">
                  <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ optional($r->categories->first())->{"name_{$loc}"} ?? optional($r->categories->first())->name_id ?? 'Artikel' }}
                  </div>
                  <h3 class="font-semibold group-hover:text-indigo-600 line-clamp-2">{{ $rTitle }}</h3>
                  <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $r->author->name ?? 'Admin' }} • {{ optional($r->published_at)->translatedFormat('d M Y') }}
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      </section>
    @endif

  </div>
</x-page.index>
