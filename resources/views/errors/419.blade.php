@extends('errors::layout')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', 'The page has expired.')
@section('actions')
    <a href="{{ url()->previous(route('web.home.index')) }}" title="Go Back">Go Back</a>
@endsection
