@extends('skeleton')

@section('page')

    <h1>Welcome to your portal</h1>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nec dapibus lacus. In hac habitasse platea dictumst. Donec facilisis sem semper odio viverra, nec mattis felis sodales. Curabitur blandit, dui vel venenatis consequat, erat ligula semper orci, a scelerisque nisi risus feugiat ipsum. Integer molestie felis vel dignissim varius. Donec aliquet viverra scelerisque. Pellentesque eget congue mi. Duis tincidunt tortor orci, hendrerit dignissim ipsum facilisis ut. Praesent nec nulla non ligula pulvinar semper ut sed metus. Curabitur arcu lacus, vestibulum in molestie sed, sollicitudin eu lorem. Ut tempus et augue sed sollicitudin. Sed convallis nisl a felis gravida lobortis.</p>

    {{-- todo: buttons here for now - rearrange when designs are ready --}}
    <div>
        <a href="{{ route('web.space-calculator.index') }}" title="New Enquiry">New Enquiry</a>
    </div>
    <div>
        <a href="{{ route('web.profile.index') }}" title="Edit profile">Edit profile</a>
    </div>

@endsection
