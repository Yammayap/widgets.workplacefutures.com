<div>
    @if(!$disableLabel)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <select
            name="{{ $name }}"
            id="{{ $name }}"
            class="@foreach($classes as $class){{ $class . (!$loop->last ? ' ' : '') }}@endforeach"
            @if(!is_null($placeholder))
                placeholder="{{ $placeholder }}"
            @endif
            {{ $required ? 'required' : '' }}>
        @if($allowBlank)
            <option value="" disabled{{ is_null($selected) || !in_array($selected, $options) ? ' selected' : '' }}>-</option>
        @endif
        @foreach($options as $value => $label)
            <option value="{{ $value }}"{{ !is_null($selected) && $selected == $value ? ' selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</div>