@extends('skeleton')

@section('page')
    <h1>Sign in</h1>

    <p>Enter your email address below, and we'll send you a link to access your portal.</p>

    <form method="post" action="{{ route('web.auth.sign-in.post') }}" novalidate>
        @csrf
        <x-errors :errors="$errors" />
        <x-forms.label for="email">Email address</x-forms.label>
        <x-forms.text type="email" id="email" name="email" :value="old('email')" />
        <button type="submit" title="Get my sign in link">Get my sign in link</button>
    </form>

@endsection
