@extends('skeleton')

@section('page')

    <h1>Update your profile</h1>

    @if($user->has_completed_profile)
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nec dapibus lacus. In hac habitasse platea dictumst. Donec facilisis sem semper odio viverra, nec mattis felis sodales. Curabitur blandit, dui vel venenatis consequat, erat ligula semper orci, a scelerisque nisi risus feugiat ipsum. Integer molestie felis vel dignissim varius. Donec aliquet viverra scelerisque. Pellentesque eget congue mi. Duis tincidunt tortor orci, hendrerit dignissim ipsum facilisis ut. Praesent nec nulla non ligula pulvinar semper ut sed metus. Curabitur arcu lacus, vestibulum in molestie sed, sollicitudin eu lorem. Ut tempus et augue sed sollicitudin. Sed convallis nisl a felis gravida lobortis.</p>
    @else
        <p>You must complete your profile before using this website. Please fill out the form to proceed.</p>
    @endif

    <form method="post" action="{{ route('web.profile.index.post') }}" novalidate>

        @csrf

        <x-errors :errors="$errors" />

        <div>
            <x-forms.label for="first_name">First Name *</x-forms.label>
            <x-forms.text id="first_name" name="first_name" :value="old('first_name', $user->first_name)" />
        </div>

        <div>
            <x-forms.label for="last_name">Last Name *</x-forms.label>
            <x-forms.text id="last_name" name="last_name" :value="old('last_name', $user->last_name)" />
        </div>

        <div> {{-- todo: discuss - should we allow editing of the email address or not? If we do then we may need more confirmation emails etc set up... --}}
            <x-forms.label for="email_address">Email address</x-forms.label>
            {{ $user->email }}
        </div>

        <div>
            <x-forms.label for="company_name">Company Name</x-forms.label>
            <x-forms.text id="company_name" name="company_name" :value="old('company_name', $user->company_name)" />
        </div>

        <div>
            <x-forms.label for="phone">Phone</x-forms.label> {{-- todo: test phone as auth user updating profile --}}
            <x-forms.text type="tel" id="phone" name="phone" :value="old('phone', $user->phone)" />
        </div>

        <div>
            <x-forms.checkbox name="marketing_opt_in" id="marketing_opt_in" :checked="old('marketing_opt_in', $user->marketing_opt_in)" value="1">I'm happy to receive marketing from Workplace Futures Group</x-forms.checkbox>
        </div>

        <div>
            <button type="submit" title="Save changes">Save changes</button>
        </div>

    </form>

@endsection
