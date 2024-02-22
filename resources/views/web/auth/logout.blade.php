@extends('skeleton')

@section('page')
    {{-- todo: real content here - doesn't have to be much? --}}
    <h1>Are you sure you want to logout?</h1>

    <p>Lorem ipsum dolor sit amet</p>

    <form method="post" action="{{ route('web.logout.post') }}">
        @csrf
        <button type="submit" title="Logout">Logout</button>
    </form>

@endsection