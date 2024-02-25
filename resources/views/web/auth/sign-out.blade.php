@extends('skeleton')

@section('page')
    <h1>Are you sure you want to sign out?</h1>

    <form method="post" action="{{ route('web.auth.sign-out.post') }}">
        @csrf
        <button type="submit" title="Yes, sign out">Yes, sign out</button>
    </form>

    <a href="{{ route('web.home.index') }}" title="Back to portal">Back to portal</a>

@endsection
