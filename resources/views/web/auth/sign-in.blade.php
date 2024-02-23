@extends('skeleton')

@section('page')
    {{-- todo: real content here - doesn't have to be much? --}}
    <h1>Sign In</h1>

    <p>Lorem ipsum dolor sit amet</p>

    <form method="post" action="{{ route('web.auth.sign-in.post') }}" novalidate>
        @csrf
        <x-errors :errors="$errors" />
        <x-forms.label for="email">Email address</x-forms.label>
        <x-forms.text type="email" id="email" name="email" :value="old('email')" />
        <button type="submit" title="Sign In">Sign In</button>
    </form>

    <a href="{{ route('web.home.index') }}" title="Back to portal">Back to portal</a>

@endsection