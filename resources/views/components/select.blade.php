<div>
    <select {{ $attributes }}>
        @if($allowBlank)
            <option value="">-</option>
        @endif
        @foreach($options as $option)
            <option value="{{ $option["value"] }}" @selected(strval($option['value']) === strval($selected))>{{ $option["label"] }}</option>
        @endforeach
    </select>
</div>
