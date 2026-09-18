@props(['tier'])

<div
    {{ $attributes->class(['flex flex-col gap-6 border-t-4 pt-6']) }}
    style="border-color: var(--tier-{{ $tier['level'] }})"
    data-reveal
>
    <div>
        <div class="flex items-center gap-4">
            <span class="section-number text-primary">Tier {{ str_pad($tier['level'], 2, '0', STR_PAD_LEFT) }}</span>
            @if ($tier['featured'])
                <span class="eyebrow text-primary">Most popular</span>
            @endif
        </div>
        <h3 class="display mt-3 text-3xl">{{ $tier['name'] }}</h3>
        <p class="mt-3 max-w-[38ch] text-secondary">{{ $tier['for'] }}</p>
    </div>

    <ul class="flex flex-1 flex-col gap-3 border-t border-rule pt-6">
        @foreach ($tier['features'] as $feature)
            <li class="flex gap-3 text-base">
                <span class="text-primary" aria-hidden="true">&mdash;</span>
                <span>{{ $feature }}</span>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('contact', ['tier' => $tier['slug']]) }}" class="btn btn-primary w-full">
        Enquire about {{ $tier['name'] }}
    </a>
</div>
