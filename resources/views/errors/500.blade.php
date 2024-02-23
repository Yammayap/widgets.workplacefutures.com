@extends('errors::layout')

@section('title', __('Internal Server Error'))
@section('code', '500')
@section('message')
    <p>It seems we're experiencing some technical problems.</p>
    <p>Please try again later.</p>
@endsection
@section('actions')
    <a href="{{ url()->previous(route('web.home.index')) }}" title="Go Back">Go Back</a>
@endsection
