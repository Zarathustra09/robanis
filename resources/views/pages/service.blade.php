@extends('layouts.app')

@section('title', $service['name'])
@section('title-suffix', 'Robanis')
@section('description', $service['intro'])

@section('content')

    <section class="border-b border-rule py-32">
        <div class="mx-auto max-w-6xl px-6">
            <p class="eyebrow" data-reveal>
                <a href="{{ route('services') }}" class="hover:text-primary">Services</a>
                <span aria-hidden="true">/</span>
                {{ $service['nav_label'] }}
            </p>
            <h1 class="display mt-6 max-w-3xl" data-reveal style="--i:1">{{ $service['headline'] }}</h1>
            <p class="mt-8 max-w-[55ch] text-lg text-secondary" data-reveal style="--i:2">{{ $service['intro'] }}</p>
        </div>
    </section>

    <section class="py-32" aria-labelledby="tiers-heading">
        <div class="mx-auto max-w-7xl px-6">
            <h2 id="tiers-heading" class="sr-only">{{ $service['name'] }} tiers</h2>
            <div class="grid gap-x-10 gap-y-16 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($service['tiers'] as $tier)
                    <x-tier-card :tier="$tier" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-rule py-32">
        <div class="mx-auto max-w-6xl px-6 grid gap-16 lg:grid-cols-2">
            <div data-reveal>
                <p class="eyebrow">Not sure which tier</p>
                <h2 class="display mt-6 max-w-lg text-4xl">Tell us what you're running.</h2>
                <div class="mt-10 flex flex-wrap items-center gap-8">
                    <a href="{{ route('contact') }}" class="btn btn-cta">Book a call</a>
                    <a href="{{ route('services') }}#faq" class="link-plain">Read the FAQ</a>
                </div>
            </div>
            <div data-reveal style="--i:1">
                <p class="eyebrow">Other services</p>
                <ul class="mt-6 border-t border-rule">
                    @foreach ($otherServices as $other)
                        <li class="border-b border-rule">
                            <a href="{{ route('services.show', $other['slug']) }}" class="flex items-baseline justify-between gap-6 py-5 hover:text-primary">
                                <span class="text-lg">{{ $other['name'] }}</span>
                                <span class="text-base text-secondary">{{ $other['nav_blurb'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

@endsection
