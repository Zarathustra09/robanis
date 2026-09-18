@extends('layouts.app')

@section('title', 'Robanis')
@section('title-suffix', 'Agentic systems and agentic SEO')
@section('description', 'Robanis connects your existing systems with autonomous agents and makes your business findable in AI search — without the hype.')

@section('content')

    {{-- Hero --}}
    <section class="relative flex min-h-svh flex-col justify-center overflow-hidden">
        <div class="dot-grid pointer-events-none absolute inset-0" aria-hidden="true"></div>
        <div class="relative mx-auto w-full max-w-6xl px-6 py-32">
            <p class="eyebrow" data-reveal>IT solutions &middot; agentic systems</p>
            <h1 class="display mt-6 max-w-4xl" data-reveal style="--i:1">
                Agents that run your systems and make you findable.
            </h1>
            <p class="mt-8 max-w-[50ch] text-lg text-secondary" data-reveal style="--i:2">
                We connect the tools you already run with agents that take real action across them,
                and shape your presence for search engines and the AI models people ask instead.
            </p>
            <div class="mt-10 flex flex-wrap items-center gap-8" data-reveal style="--i:3">
                <a href="{{ route('contact') }}" class="btn btn-cta">Book a call</a>
                <a href="{{ route('services') }}" class="link-plain">See services</a>
            </div>
        </div>
    </section>

    {{-- 01 Services --}}
    <section class="border-t border-rule py-32" id="services">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-heading number="01" eyebrow="What we do" title="Three disciplines, one operating model." />

            <div class="mt-16 grid gap-16 md:grid-cols-3 md:gap-0 md:divide-x md:divide-rule">
                @foreach ($services as $service)
                    <x-service-line :service="$service" style="--i:{{ $loop->index }}" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- 02 Why agentic --}}
    <section class="border-t border-rule py-32">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-heading number="02" eyebrow="The argument" title="Static automation breaks. Agents adapt." />

            <div class="mt-16 grid gap-16 lg:grid-cols-2 lg:items-center">
                <div class="flex flex-col gap-10">
                    <div data-reveal>
                        <h3 class="text-lg">Scripts follow rules. Agents read context.</h3>
                        <p class="mt-3 max-w-[50ch] text-secondary">
                            A script executes the exact steps it was given and stops working the moment an
                            input changes shape. An agent reads the state of a system, decides what action
                            applies, and keeps working when the unexpected happens.
                        </p>
                    </div>
                    <div data-reveal style="--i:1">
                        <h3 class="text-lg">Integration used to mean middleware. Now it means judgment.</h3>
                        <p class="mt-3 max-w-[50ch] text-secondary">
                            Connecting a CRM to a ticketing system once meant a fixed mapping between fields.
                            An agent can reconcile the two, flag what doesn't match, and hand off to a
                            person only when it's genuinely unsure.
                        </p>
                    </div>
                    <div data-reveal style="--i:2">
                        <h3 class="text-lg">Search is no longer a list of links.</h3>
                        <p class="mt-3 max-w-[50ch] text-secondary">
                            AI Overviews, ChatGPT and Perplexity answer questions directly, drawing on
                            structured data and entity clarity — not keyword density. Sites that aren't
                            built for retrieval don't get cited, regardless of how they rank.
                        </p>
                    </div>
                </div>

                <div class="hidden lg:block" aria-hidden="true" data-reveal style="--i:1">
                    <svg viewBox="0 0 320 240" fill="none" class="w-full text-primary">
                        <circle cx="40" cy="60" r="4" stroke="currentColor"/>
                        <circle cx="160" cy="30" r="4" stroke="currentColor"/>
                        <circle cx="280" cy="70" r="4" stroke="currentColor"/>
                        <circle cx="100" cy="140" r="4" stroke="currentColor"/>
                        <circle cx="230" cy="150" r="4" stroke="currentColor"/>
                        <circle cx="60" cy="210" r="4" stroke="currentColor"/>
                        <circle cx="190" cy="210" r="4" stroke="currentColor"/>
                        <path d="M40 60L160 30M160 30L280 70M40 60L100 140M160 30L100 140M160 30L230 150M280 70L230 150M100 140L60 210M100 140L190 210M230 150L190 210" stroke="currentColor" stroke-width="1" opacity="0.5"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- Closing CTA --}}
    <section class="border-t border-rule py-32">
        <div class="mx-auto max-w-6xl px-6" data-reveal>
            <p class="eyebrow">Ready when you are</p>
            <h2 class="display mt-6 max-w-2xl text-4xl">Tell us what you're running, we'll tell you what's possible.</h2>
            <div class="mt-10 flex flex-wrap items-center gap-8">
                <a href="{{ route('contact') }}" class="btn btn-cta">Book a call</a>
                <a href="{{ route('services') }}#approach" class="link-plain">See how we work</a>
            </div>
        </div>
    </section>

@endsection
