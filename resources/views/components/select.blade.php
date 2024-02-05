<div>
    <select {{ $attributes->whereDoesntStartWith('options') }}>
        @if($allowBlank)
            <option value="" disabled{{ is_null($selected) || !in_array($selected, $options) ? ' selected' : '' }}>-</option>
        @endif
        @foreach($options as $option)
            <option value="{{ $option["value"] }}"{{ !is_null($selected) && $selected == $option["value"] ? ' selected' : '' }}>{{ $option["label"] }}</option>
        @endforeach
    </select>
</div>