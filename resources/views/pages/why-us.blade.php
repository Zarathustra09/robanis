@extends('layouts.app')

@section('title', 'Why us')
@section('title-suffix', 'Robanis')
@section('description', 'Robanis consultants carry both technical depth and business fluency — so the work comes with a case leadership can approve, not just a build.')

@section('content')

    <section class="border-b border-rule py-32">
        <div class="mx-auto max-w-6xl px-6">
            <p class="eyebrow" data-reveal>Why us</p>
            <h1 class="display mt-6 max-w-3xl" data-reveal style="--i:1">
                Consultants fluent in software and business.
            </h1>
            <p class="mt-8 max-w-[55ch] text-lg text-secondary" data-reveal style="--i:2">
                Our consultants carry experience that spans software, business operations and value
                articulation — so what we build comes with a case your leadership can approve, not
                just a technical spec.
            </p>
        </div>
    </section>

    <section class="border-b border-rule py-16">
        <div class="mx-auto max-w-6xl px-6" data-reveal>
            <x-placeholder-image label="Team photo" :width="1600" :height="700" alt="The Robanis team" />
        </div>
    </section>

    <section class="border-b border-rule py-32">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-heading eyebrow="What sets us apart" title="Depth on both sides of the table." />

            @php
                $strengths = [
                    [
                        'label' => 'Technical depth',
                        'copy' => "Our consultants have shipped production software, integrations and data pipelines — not just prototypes. We read your systems before we recommend anything.",
                    ],
                    [
                        'label' => 'Business fluency',
                        'copy' => 'Experience in operations, sales and finance, not only engineering. We scope around your margins, your team\'s time and how the business actually runs.',
                    ],
                    [
                        'label' => 'Value articulation',
                        'copy' => 'We translate technical work into cost, risk, time saved and revenue at stake — reasoning you can defend in a budget meeting, not just a demo.',
                    ],
                ];
            @endphp

            <div class="mt-16 grid gap-16 md:grid-cols-3">
                @foreach ($strengths as $i => $strength)
                    <div data-reveal style="--i:{{ $i }}">
                        <x-placeholder-image :label="$strength['label']" :width="800" :height="600" />
                        <h3 class="mt-6 text-lg">{{ $strength['label'] }}</h3>
                        <p class="mt-2 max-w-[40ch] text-secondary">{{ $strength['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Founder quote --}}
    <section class="border-b border-rule py-32">
        <div class="mx-auto max-w-6xl px-6 grid gap-12 lg:grid-cols-[minmax(0,320px)_1fr] lg:items-center">
            <div data-reveal class="mx-auto w-full max-w-xs lg:mx-0">
                <x-placeholder-image
                    label="Heal Joshua C. Pardo"
                    :width="600"
                    :height="750"
                    alt="Heal Joshua C. Pardo, CEO and Founder of Robanis"
                />
            </div>
            <figure data-reveal style="--i:1">
                <span class="eyebrow">From the founder</span>
                <blockquote class="display mt-4 max-w-2xl text-3xl">
                    &ldquo;We want you to blossom as a flower and be as resilient as a mighty tree.&rdquo;
                </blockquote>
                <figcaption class="mt-6 text-secondary">
                    Heal Joshua C. Pardo — CEO &amp; Founder
                </figcaption>
                <p class="mt-6 max-w-[55ch] text-secondary">
                    The mighty tree is a deliberate echo of the name: Robanis comes from <em>robur</em>,
                    Latin for oak — the wood chosen for what has to hold weight over time, not for how
                    it looks on day one. That's the standard we hold the work to.
                </p>
            </figure>
        </div>
    </section>

    <section class="py-32">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-heading eyebrow="How we think about the work" title="What we work by." />

            @php
                $principles = [
                    [
                        'n' => '01',
                        'label' => 'Build on what you already run',
                        'copy' => "We connect and extend your existing systems instead of asking you to replace them. A rip-and-replace project serves the vendor more than it serves you.",
                    ],
                    [
                        'n' => '02',
                        'label' => 'Agents act, people decide',
                        'copy' => 'Every agent we build has a defined boundary for what it can act on alone and where it hands off to a person. Judgment calls stay with your team.',
                    ],
                    [
                        'n' => '03',
                        'label' => 'Measure visibility the way AI actually retrieves it',
                        'copy' => 'Structured data, entity clarity and content shaped for retrieval — not keyword density. We report against how AI systems actually cite a source.',
                    ],
                    [
                        'n' => '04',
                        'label' => 'Plain reporting, not a sales narrative',
                        'copy' => "You get what changed and why, on a schedule you can rely on. No dashboard theater between the reports that matter.",
                    ],
                ];
            @endphp

            <div class="mt-16 border-t border-rule">
                <div class="grid gap-10 pt-10 md:grid-cols-2 md:gap-x-16 md:gap-y-12">
                    @foreach ($principles as $i => $principle)
                        <div data-reveal style="--i:{{ $i }}">
                            <span class="section-number">{{ $principle['n'] }}</span>
                            <h3 class="mt-3 text-lg">{{ $principle['label'] }}</h3>
                            <p class="mt-2 max-w-[45ch] text-base text-secondary">{{ $principle['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="border-t border-rule py-32">
        <div class="mx-auto max-w-6xl px-6" data-reveal>
            <p class="eyebrow">Get in touch</p>
            <h2 class="display mt-6 max-w-2xl text-4xl">Tell us what you're running.</h2>
            <div class="mt-10 flex flex-wrap items-center gap-8">
                <a href="{{ route('contact') }}" class="btn btn-cta">Book a call</a>
                <a href="{{ route('services') }}#approach" class="link-plain">See how we work</a>
            </div>
        </div>
    </section>

@endsection
