<footer class="border-t border-rule">
    <div class="mx-auto max-w-6xl px-6 py-12">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <nav class="flex flex-wrap gap-6 text-base" aria-label="Footer">
                <a href="{{ route('services') }}" class="link-plain border-b-0 hover:text-primary">Services</a>
                <a href="{{ route('services') }}#approach" class="link-plain border-b-0 hover:text-primary">Approach</a>
                <a href="{{ route('why-us') }}" class="link-plain border-b-0 hover:text-primary">Why us</a>
                <a href="{{ route('contact') }}" class="link-plain border-b-0 hover:text-primary">Contact</a>
            </nav>
            <p class="text-base text-secondary">&copy; {{ now()->year }} Robanis. All rights reserved.</p>
        </div>
        <p class="mt-8 max-w-[65ch] text-base text-secondary">
            Robanis takes its name from <em>robur</em>, Latin for oak — strength built to last.
        </p>
    </div>
</footer>
