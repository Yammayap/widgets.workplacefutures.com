@extends('skeleton')

@section('page')
    {{-- todo: real content here - doesn't have to be much? --}}
    <h1>Are you sure you want to sign out?</h1>

    <p>Lorem ipsum dolor sit amet</p>

    <form method="post" action="{{ route('web.sign-out.post') }}">
        @csrf
        <button type="submit" title="Sign Out">Sign Out</button>
    </form>

    <a href="{{ route('web.home.index') }}" title="Back to portal">Back to portal</a>

@endsection