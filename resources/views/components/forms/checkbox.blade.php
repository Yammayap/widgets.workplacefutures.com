<div>
    <input type="checkbox" {{ $attributes->except(['checked']) }} {{ $attributes->get('checked') ? 'checked' : '' }} />
    <label for="{{ $attributes->get('id') }}">{{ $slot }}</label>
</div>
