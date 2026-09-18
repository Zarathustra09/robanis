@props(['label', 'width' => 800, 'height' => 600, 'alt' => null])

@php
    // placehold.co takes bg/fg as hex without the '#'. One pair per theme,
    // pulled from the palette (base-200/secondary in light, base-200/
    // secondary in dark) so the frame reads as part of the page, not a
    // random grey box.
    $encodedLabel = rawurlencode($label);
    $lightSrc = "https://placehold.co/{$width}x{$height}/EDE9E1/5A6763/svg?text={$encodedLabel}";
    $darkSrc = "https://placehold.co/{$width}x{$height}/1E2B26/9AA8A3/svg?text={$encodedLabel}";
@endphp

<span {{ $attributes->class('block overflow-hidden border border-rule') }}>
    <img
        data-img="light"
        src="{{ $lightSrc }}"
        width="{{ $width }}"
        height="{{ $height }}"
        loading="lazy"
        alt="Placeholder: {{ $alt ?? $label }}"
        class="block h-auto w-full"
    >
    <img
        data-img="dark"
        src="{{ $darkSrc }}"
        width="{{ $width }}"
        height="{{ $height }}"
        loading="lazy"
        alt="Placeholder: {{ $alt ?? $label }}"
        class="hidden h-auto w-full"
    >
</span>
