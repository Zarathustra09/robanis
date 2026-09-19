<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Robanis') — @yield('title-suffix', 'IT solutions, agentic systems')</title>
    <meta name="description" content="@yield('description', 'Robanis builds agentic system integrations and agentic SEO for the AI search era.')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Blocking, so the theme is set before first paint — no flash of the wrong theme.
         Light is the default for everyone; dark only applies after a visitor picks it
         with the header toggle (stored in localStorage). The OS colour scheme is ignored. --}}
    <script>
        (function () {
            try {
                var theme = localStorage.getItem('robanis-theme') === 'robanis-dark' ? 'robanis-dark' : 'robanis-light';
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'robanis-light');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-100 text-base-content font-sans">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:bg-base-100 focus:px-4 focus:py-2 focus:border focus:border-rule">
        Skip to content
    </a>

    @include('partials.header')

    <main id="main" data-inert-on-menu>
        @yield('content')
    </main>

    <div data-inert-on-menu>
        @include('partials.footer')
    </div>
</body>
</html>
