@extends('errors::layout')

@section('title', __('Method Not Allowed'))
@section('code', '405')
@section('message')
    <p>The resource you're trying to access exists, but you can't access it via this method.</p>
    <p>Please try again.</p>
@endsection
@section('actions')
    <a href="{{ url()->previous(route('web.home.index')) }}" title="Go Back">Go Back</a>
@endsection
