@php
    $serviceLines = App\Support\Offerings::all();
    $navLinks = [
        ['label' => 'Why us', 'route' => 'why-us'],
        ['label' => 'Contact', 'route' => 'contact'],
    ];
    $onService = fn (string $slug) => request()->routeIs('services.show') && request()->route('service') === $slug;
@endphp

<header data-header class="sticky top-0 z-40 bg-base-100">
    <div class="mx-auto flex h-20 max-w-6xl items-center justify-between px-6">
        <a href="{{ route('home') }}" class="text-lg tracking-tight">
            Robanis<span class="text-primary">/</span>
        </a>

        <nav class="hidden items-center gap-8 md:flex" aria-label="Primary">
            <div class="relative" data-submenu>
                <button
                    type="button"
                    data-submenu-toggle
                    aria-expanded="false"
                    aria-controls="services-menu"
                    @class(['flex items-center gap-2 text-sm hover:text-primary', 'text-primary' => request()->routeIs('services*')])
                >
                    Services
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" aria-hidden="true">
                        <path d="M1 3L5 7L9 3" stroke="currentColor" stroke-width="1"/>
                    </svg>
                </button>

                <div
                    id="services-menu"
                    data-submenu-panel
                    class="absolute left-0 top-full z-50 mt-6 hidden w-80 border border-rule bg-base-100"
                >
                    <ul>
                        @foreach ($serviceLines as $line)
                            <li class="border-b border-rule">
                                <a
                                    href="{{ route('services.show', $line['slug']) }}"
                                    @if ($onService($line['slug'])) aria-current="page" @endif
                                    class="block px-5 py-4 hover:text-primary aria-[current=page]:text-primary"
                                >
                                    <span class="block text-sm">{{ $line['nav_label'] }}</span>
                                    <span class="mt-1 block text-base text-secondary">{{ $line['nav_blurb'] }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a
                                href="{{ route('services') }}"
                                @if (request()->routeIs('services')) aria-current="page" @endif
                                class="eyebrow block px-5 py-4 hover:text-primary"
                            >
                                Overview, approach and FAQ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            @foreach ($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    @if (request()->routeIs($link['route'])) aria-current="page" @endif
                    class="text-sm hover:text-primary aria-[current=page]:text-primary"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="hidden items-center gap-6 md:flex">
            @include('partials.theme-toggle')
            <a href="{{ route('contact') }}" class="link-plain text-sm">Book a call</a>
        </div>

        <div class="flex items-center gap-4 md:hidden">
            @include('partials.theme-toggle')
            <button
                type="button"
                data-menu-toggle
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="Open menu"
                class="flex h-9 w-9 items-center justify-center border border-rule"
            >
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M1 4H15M1 8H15M1 12H15" stroke="currentColor" stroke-width="1"/>
                </svg>
            </button>
        </div>
    </div>

    <div
        id="mobile-menu"
        data-menu
        class="fixed inset-0 z-50 hidden flex-col overflow-y-auto bg-base-100 md:hidden"
    >
        <div class="mx-auto flex h-20 w-full max-w-6xl shrink-0 items-center justify-between px-6">
            <span class="text-lg tracking-tight">Robanis<span class="text-primary">/</span></span>
            <button
                type="button"
                data-menu-toggle
                aria-expanded="true"
                aria-controls="mobile-menu"
                aria-label="Close menu"
                class="flex h-9 w-9 items-center justify-center border border-rule"
            >
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M1 1L15 15M1 15L15 1" stroke="currentColor" stroke-width="1"/>
                </svg>
            </button>
        </div>

        <nav class="flex flex-1 flex-col justify-center gap-8 px-6 py-12" aria-label="Mobile">
            <div>
                <a href="{{ route('services') }}" class="display text-3xl">Services</a>
                <ul class="mt-4 flex flex-col gap-3 border-l border-rule pl-5">
                    @foreach ($serviceLines as $line)
                        <li>
                            <a href="{{ route('services.show', $line['slug']) }}" class="text-lg text-secondary hover:text-primary">
                                {{ $line['nav_label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}" class="display text-3xl">{{ $link['label'] }}</a>
            @endforeach
            <a href="{{ route('contact') }}" class="display text-3xl text-primary">Book a call</a>
        </nav>
    </div>
</header>
