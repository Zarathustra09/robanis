<button
    type="button"
    data-theme-toggle
    aria-label="Switch to dark theme"
    aria-pressed="false"
    class="flex h-9 w-9 items-center justify-center border border-rule text-current"
>
    <svg data-icon="sun" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
        {{-- Sun — shown in light theme --}}
        <circle cx="8" cy="8" r="3.5" stroke="currentColor" stroke-width="1"/>
        <path d="M8 0.5V2.5M8 13.5V15.5M15.5 8H13.5M2.5 8H0.5M13.3 2.7L11.9 4.1M4.1 11.9L2.7 13.3M13.3 13.3L11.9 11.9M4.1 4.1L2.7 2.7" stroke="currentColor" stroke-width="1"/>
    </svg>
    <svg data-icon="moon" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
        {{-- Moon — shown in dark theme --}}
        <path d="M14 9.3A6 6 0 116.7 2 4.7 4.7 0 0014 9.3Z" stroke="currentColor" stroke-width="1"/>
    </svg>
</button>
