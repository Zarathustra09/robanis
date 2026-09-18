@props(['question'])

<details class="group border-b border-rule py-6">
    <summary class="flex cursor-pointer list-none items-center justify-between gap-6">
        <span class="text-lg">{{ $question }}</span>
        <span class="eyebrow shrink-0" aria-hidden="true">
            <span class="group-open:hidden">+</span>
            <span class="hidden group-open:inline">&minus;</span>
        </span>
    </summary>
    <div class="mt-4 max-w-[65ch] text-secondary">
        {{ $slot }}
    </div>
</details>
