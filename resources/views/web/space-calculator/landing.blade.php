@extends('skeleton')

@section('page')

    {{-- todo: this is all dummy content - to be replaced --}}
    <h1>Welcome to the Space Calculator</h1>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean arcu quam, blandit eget sagittis nec, venenatis nec tellus. Cras mollis egestas molestie. Nam elit felis, facilisis eu enim quis, molestie iaculis nisi. Cras malesuada neque nec lacinia pellentesque. Etiam congue ante eu ante rutrum, nec varius ligula lacinia. Quisque sit amet dignissim ex, a ullamcorper sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras accumsan a mi non varius. Aenean dignissim finibus placerat. Etiam condimentum facilisis malesuada. Aenean viverra cursus nisi. Duis arcu nisl, viverra quis ullamcorper ut, lacinia id nibh.</p>

    {{-- wording and placement of these buttons TBC --}}
    <div>
        <div>
            <a href="#" title="Returning User">
                Returning User
            </a>
        </div>
        <div>
            <a href="#" title="I am new here"> {{-- in next card/PR this will link to SC input page --}}
                I am new here
            </a>
        </div>
    </div>

@endsection