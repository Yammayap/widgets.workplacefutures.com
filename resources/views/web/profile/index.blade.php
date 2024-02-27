@extends('skeleton')

@section('page')

    <h1>Update your profile</h1>

    @if($user->has_completed_profile)
        <p>Keep your personal details and preferences up-to-date. The fields marked with * are required.</p>
    @else
        <p>To continue, you need to complete your profile. The fields marked with * are required.</p>
    @endif

    <form method="post" action="{{ route('web.profile.index.post') }}" novalidate>

        @csrf

        <x-errors :errors="$errors" />

        <div>
            <x-forms.label for="first_name">First name *</x-forms.label>
            <x-forms.text id="first_name" name="first_name" :value="old('first_name', $user->first_name)" />
        </div>

        <div>
            <x-forms.label for="last_name">Last name *</x-forms.label>
            <x-forms.text id="last_name" name="last_name" :value="old('last_name', $user->last_name)" />
        </div>

        <div>
            <x-forms.label for="email_address">Email address</x-forms.label>
            {{ $user->email }}
        </div>

        <div>
            <x-forms.label for="company_name">Company name</x-forms.label>
            <x-forms.text id="company_name" name="company_name" :value="old('company_name', $user->company_name)" />
        </div>

        <div>
            <x-forms.label for="phone">Phone</x-forms.label>
            <x-forms.text type="tel" id="phone" name="phone" :value="old('phone', $user->phone)" />
        </div>

        <div>
            <x-forms.checkbox name="marketing_opt_in" id="marketing_opt_in" :checked="old('marketing_opt_in', $user->marketing_opt_in)" value="1">I'm happy to receive marketing from Workplace Futures Group</x-forms.checkbox>
        </div>

        <div>
            <button type="submit" title="Save my profile">Save my profile</button>
        </div>

    </form>

@endsection
