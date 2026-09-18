@extends('layouts.app')

@section('title', 'Contact')
@section('title-suffix', 'Robanis')
@section('description', 'Tell Robanis what systems you run and what you need — we reply within one business day.')

@section('content')

    <section class="py-32">
        <div class="mx-auto max-w-6xl px-6">
            <div class="grid gap-16 lg:grid-cols-2">
                <div data-reveal>
                    <p class="eyebrow">Get in touch</p>
                    <h1 class="display mt-6 max-w-lg">Tell us what you're running.</h1>
                    <p class="mt-8 max-w-[50ch] text-secondary">
                        A short note is enough. We'll reply within one business day with next steps, not
                        a sales deck.
                    </p>
                </div>

                <div data-reveal style="--i:1">
                    @if (session('status'))
                        <p role="status" class="mb-8 border border-rule px-4 py-3 text-base">
                            {{ session('status') }}
                        </p>
                    @endif

                    @if ($tierLabel)
                        <p class="eyebrow mb-8">
                            Enquiring about: {{ $tierLabel }}
                        </p>
                    @endif

                    <form method="POST" action="{{ route('leads.store') }}" class="flex flex-col gap-8">
                        @csrf
                        <input type="hidden" name="tier_interest" value="{{ old('tier_interest', $tierInterest) }}">
                        <input type="hidden" name="source_page" value="{{ url()->full() }}">

                        {{-- Honeypot: hidden from real visitors, left open for bots. --}}
                        <div class="absolute -left-[9999px]" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <x-field name="name" label="Name" required />
                        <x-field name="email" label="Email" type="email" required />
                        <x-field name="company" label="Company" />
                        <x-field name="message" label="Message" as="textarea" required />

                        <button type="submit" class="btn btn-cta self-start">Send enquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
