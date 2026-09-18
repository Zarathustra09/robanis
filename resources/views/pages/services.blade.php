@extends('layouts.app')

@section('title', 'Services')
@section('title-suffix', 'Robanis')
@section('description', 'Agentic SEO, agentic AI and software solutions — three service lines, each with four tiers, from an independent advisory engagement to a dedicated team.')

@section('content')

    <section class="border-b border-rule py-32">
        <div class="mx-auto max-w-6xl px-6">
            <p class="eyebrow" data-reveal>Services</p>
            <h1 class="display mt-6 max-w-3xl" data-reveal style="--i:1">
                Three service lines, one way of working.
            </h1>
            <p class="mt-8 max-w-[55ch] text-lg text-secondary" data-reveal style="--i:2">
                Each line has the same four tiers, from an independent advisory engagement through to
                a dedicated team. Take one, or combine them — the same team audits, builds and
                operates all three.
            </p>
        </div>
    </section>

    <section class="py-32">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="sr-only">Service lines</h2>
            <div class="grid gap-16 md:grid-cols-3 md:gap-0 md:divide-x md:divide-rule">
                @foreach ($services as $service)
                    <x-service-line :service="$service" style="--i:{{ $loop->index }}" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Approach --}}
    <section class="border-t border-rule py-32" id="approach">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-heading eyebrow="How we work" title="Four steps, no surprises.">
                Every engagement follows the same order, whether it's one integration or a full
                agentic SEO rebuild. We don't skip the audit to get to the build faster.
            </x-section-heading>

            @php
                $steps = [
                    ['n' => '01', 'label' => 'Audit', 'copy' => 'We map your systems, data and current search visibility before proposing anything.'],
                    ['n' => '02', 'label' => 'Design', 'copy' => 'We define what each agent does, what it can act on, and where a human stays in the loop.'],
                    ['n' => '03', 'label' => 'Build', 'copy' => 'We connect, configure and test against your real systems, not a demo environment.'],
                    ['n' => '04', 'label' => 'Operate', 'copy' => 'We monitor, report and adjust as your systems and search landscape change.'],
                ];
            @endphp
            <div class="mt-16 border-t border-rule">
                <div class="grid gap-10 pt-10 md:grid-cols-4 md:gap-8">
                    @foreach ($steps as $i => $step)
                        <div data-reveal style="--i:{{ $i }}">
                            <span class="section-number">{{ $step['n'] }}</span>
                            <h3 class="mt-3 text-lg">{{ $step['label'] }}</h3>
                            <p class="mt-2 text-base text-secondary">{{ $step['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="border-t border-rule py-32" id="faq">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-heading eyebrow="Questions" title="Frequently asked." />

            <div class="mt-16 max-w-3xl" data-reveal>
                <x-faq-item question='What does "agentic" mean, concretely?'>
                    An agentic system doesn't just follow a fixed script — it reads the current state of
                    your systems, decides which action applies, takes it, and hands off to a person when
                    it's unsure. For SEO, it means content and structured data shaped for how AI models
                    retrieve and cite information, not just how search engines rank keywords.
                </x-faq-item>
                <x-faq-item question="Can we combine service lines?">
                    Yes, and most clients do. Each line is scoped on its own, so you can start with one
                    tier in one line and add another later. Combined engagements share one team and one
                    monthly report.
                </x-faq-item>
                <x-faq-item question="What does the Advice tier commit us to?">
                    Nothing beyond the engagement itself. Advice is an independent assessment — market
                    research, an audit of where you stand, and a written roadmap. There's no obligation
                    to continue into Starter or beyond.
                </x-faq-item>
                <x-faq-item question="What's a typical timeline?">
                    Advice engagements typically wrap in one to two weeks. Build runs three to six weeks
                    from there, depending on how many systems are involved. Entry tiers move faster; the
                    larger tiers typically run six to ten weeks end to end.
                </x-faq-item>
                <x-faq-item question="Do you work with our existing stack?">
                    Yes. We integrate with what you already run rather than asking you to replace it —
                    common CRM, ERP, ticketing and helpdesk platforms, plus custom internal tools through
                    their APIs.
                </x-faq-item>
                <x-faq-item question="How are SEO results measured?">
                    Technical SEO metrics (crawl coverage, structured data validity, Core Web Vitals)
                    alongside AI-search visibility — whether your business appears in AI Overviews,
                    ChatGPT, Perplexity and Claude responses for relevant queries. You get a monthly
                    report against both.
                </x-faq-item>
                <x-faq-item question="What happens after launch?">
                    Nothing is left to drift. Every tier from Starter up includes monitoring and a
                    monthly report; Business and Enterprise add continuous monitoring, a monthly call,
                    and adjustments as your systems or the search landscape change.
                </x-faq-item>
            </div>
        </div>
    </section>

@endsection
