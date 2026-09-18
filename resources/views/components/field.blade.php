@props([
    'name',
    'label',
    'type' => 'text',
    'as' => 'input',
    'required' => false,
])

@php
    $errorId = "{$name}-error";
    $hasError = $errors->has($name);
@endphp

<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="eyebrow block">
        {{ $label }}@if ($required) <span aria-hidden="true">*</span>@endif
    </label>

    @if ($as === 'textarea')
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="4"
            @if ($required) required @endif
            aria-invalid="{{ $hasError ? 'true' : 'false' }}"
            @if ($hasError) aria-describedby="{{ $errorId }}" @endif
            class="field-underline mt-2"
        >{{ old($name) }}</textarea>
    @else
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ old($name) }}"
            @if ($required) required @endif
            aria-invalid="{{ $hasError ? 'true' : 'false' }}"
            @if ($hasError) aria-describedby="{{ $errorId }}" @endif
            class="field-underline mt-2"
        >
    @endif

    @if ($hasError)
        <p id="{{ $errorId }}" class="mt-2 text-sm text-error">{{ $errors->first($name) }}</p>
    @endif
</div>
