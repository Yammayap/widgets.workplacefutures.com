@extends('errors::layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message')
    <p>This website is temporarily unavailable because we're currently performing maintenance on our systems.</p>
    <p>Please check back again later.</p>
    <p>Sorry for any inconvenience.</p>
@endsection
@section('actions')
    <a href="{{ url()->previous(route('web.home.index')) }}" title="Go Back">Go Back</a>
@endsection
