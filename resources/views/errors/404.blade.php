@extends('errors::layout')

@section('title', __('Page Not Found'))
@section('code', '404')
@section('message')
    <p>The page you are looking for could not be found.</p>
    <p>It may have moved, or it might no longer exist.</p>
@endsection
@section('actions')
    <a href="{{ url()->previous(route('web.home.index')) }}" title="Go Back">Go Back</a>
@endsection
