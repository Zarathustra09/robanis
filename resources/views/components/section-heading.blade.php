@props([
    'number' => null,
    'eyebrow' => null,
    'title',
    'level' => 'h2',
])

<div {{ $attributes->only('class')->merge(['class' => 'max-w-[65ch]']) }} data-reveal>
    <div class="mb-4 flex items-center gap-4">
        @if ($number)
            <span class="section-number">{{ $number }}</span>
        @endif
        @if ($eyebrow)
            <span class="eyebrow">{{ $eyebrow }}</span>
        @endif
    </div>
    <{{ $level }} class="display">{{ $title }}</{{ $level }}>
    @isset($slot)
        @if (trim($slot))
            <p class="mt-6 text-secondary">{{ $slot }}</p>
        @endif
    @endisset
</div>
