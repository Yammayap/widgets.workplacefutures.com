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

    {{-- enquiries in a simple table for now. When we have designs perhaps this can be laid out nicer --}}

    <h2>Your enquiries</h2>

    @if($enquiries->isNotEmpty())

        <table style="width: 100%;text-align:left;">
            <tr>
                <th>
                    Date / time
                </th>
                <th>
                    Widget
                </th>
                <th>
                    Link
                </th>
            </tr>
            @foreach($enquiries as $enquiry)
                <tr>
                    <td>
                        {{ \App\Support\Helpers::formatDateTime($enquiry->created_at) }}
                    </td>
                    <td>
                        {{ $enquiry->widget->label() }}
                    </td>
                    <td>
                        <a href="{{ route('web.space-calculator.outputs.detailed', $enquiry->spaceCalculatorInput) }}" title="View">View</a>
                    </td>
                </tr>
            @endforeach
        </table>

        <div>
            {{ $enquiries->links() }}
        </div>

    @else

        <p>You have not made any enquiries yet.</p>

    @endif

@endsection
