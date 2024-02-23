@extends('errors::layout')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message')
    <p>You've tried to access this page too many times.</p>
    <p>Please wait for 1 minute then try again.</p>
@endsection
@section('actions')
    <a href="{{ url()->previous(route('web.home.index')) }}" title="Go Back">Go Back</a>
@endsection