<div>
    <input type="checkbox" {{ $attributes->except(['label', 'checked']) }} {{ $attributes->get('checked') ? 'checked' : '' }} />
    <label for="{{ $attributes->get('id') }}">{{ $attributes->get('label') }}</label>
</div>
