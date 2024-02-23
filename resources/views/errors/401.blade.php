@extends('errors::layout')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('You must be signed in to access the page you requested.'))
@section('actions')
    <a href="/{{-- route('web.auth.sign-in') --}}" title="Sign In">Sign In</a>
@endsection {{-- todo: change route when generic magic link PR is merged in --}}
