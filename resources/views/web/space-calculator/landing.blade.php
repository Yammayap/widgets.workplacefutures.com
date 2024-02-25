@extends('skeleton')

@section('page')

    <h1>Space calculator</h1>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean arcu quam, blandit eget sagittis nec, venenatis nec tellus. Cras mollis egestas molestie. Nam elit felis, facilisis eu enim quis, molestie iaculis nisi.</p>

    <div>
        <div>
            <a href="{{ route('web.auth.sign-in') }}" title="I've been here before">I've been here before</a>
        </div>

        <div>
            <a href="{{ route('web.space-calculator.inputs.index') }}" title="I am new here">I am new here</a>
        </div>
    </div>

@endsection
