@props(['service'])

<div {{ $attributes->class('flex flex-col px-0 md:px-10 md:first:pl-0 md:last:pr-0') }} data-reveal>
    <span class="eyebrow">{{ $service['nav_label'] }}</span>
    <h3 class="display mt-4 text-3xl">{{ $service['name'] }}</h3>
    <p class="mt-4 max-w-[50ch] text-secondary">{{ $service['intro'] }}</p>

    <ul class="mt-6 flex flex-col gap-3 text-base">
        @foreach ($service['highlights'] as $highlight)
            <li class="flex gap-3"><span class="text-primary" aria-hidden="true">&mdash;</span>{{ $highlight }}</li>
        @endforeach
    </ul>

    <a href="{{ route('services.show', $service['slug']) }}" class="link-plain mt-6 inline-block">
        See pricing<span class="sr-only"> for {{ $service['name'] }}</span>
    </a>
</div>
