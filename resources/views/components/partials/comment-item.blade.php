@php
  $children  = $grouped[$c->id] ?? collect();
  $MAX_DEPTH = 4;
  $isTarget  = isset($replyToId) && (int)$replyToId === (int)$c->id;

  // Batasi level biar nggak kebablasan
  $level = min($level, $MAX_DEPTH - 1);

  // Map level -> margin-left Tailwind (16px per step)
  $mlMap = ['ml-0','ml-4','ml-8','ml-12','ml-16'];
  $mlClass = $mlMap[$level] ?? 'ml-16';
@endphp

<div id="c-{{ $c->id }}"
     class="relative flex gap-3 p-3 rounded-2xl border border-gray-200 dark:border-gray-800 {{ $mlClass }}">

  @if($level > 0)
    {{-- Garis tipis di kiri/thread connector --}}
    <span class="absolute left-0 top-3 bottom-3 w-px bg-gray-200 dark:bg-gray-800 -translate-x-2"></span>
  @endif

  <img src="https://placehold.co/36x36"
       class="h-9 w-9 rounded-full ring-2 {{ $isTarget ? 'ring-indigo-500' : 'ring-transparent' }}"
       alt="avatar">

  <div class="flex-1">
    <div class="text-sm font-semibold">
      {{ $c->user->name ?? $c->guest_name ?? 'Pengguna' }}
    </div>

    @if($c->parent_id)
      <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Membalas komentar</div>
    @endif

    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $c->body }}</p>

    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-3">
      <span>{{ $c->created_at->diffForHumans() }}</span>

      @if($level < $MAX_DEPTH - 1)
        <a href="{{ route('article', ['slug' => $article->slug, 'reply_to' => $c->id]) }}#comments"
           class="text-indigo-600 hover:underline">Balas</a>
      @endif
    </div>

    @if($children->isNotEmpty() && $level < $MAX_DEPTH - 1)
      <div class="mt-3 space-y-3">
        @foreach($children as $child)
          @include('components.partials.comment-item', [
            'c' => $child,
            'grouped' => $grouped,
            'article' => $article,
            'level' => $level + 1,
            'replyToId' => $replyToId ?? null,
          ])
        @endforeach
      </div>
    @endif
  </div>
</div>
