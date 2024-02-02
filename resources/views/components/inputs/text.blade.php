<div>
    @if(!$disableLabel)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value }}"
            class="@foreach($classes as $class){{ $class . (!$loop->last ? ' ' : '') }}@endforeach"
            @if(!is_null($placeholder))
                placeholder="{{ $placeholder }}"
            @endif
            {{ $required ? 'required' : '' }}
                />
</div>

{{-- todo: discuss - is there a nicer way of indenting this? Or is it better to keep it all inline? (It may effect output / performance?) --}}
{{-- todo: discuss - is it possible to do an inline foreach in blade like you can with an if? --}}