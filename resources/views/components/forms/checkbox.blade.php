<div>
    <input type="checkbox" {{ $attributes }} {{ $attributes->get('checked') ? 'checked' : '' }} />
    <label for="{{ $attributes->get('id') }}">{{ $attributes->get('label') }}</label>
</div>
