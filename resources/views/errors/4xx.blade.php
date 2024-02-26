@extends('errors::layout')

@section('title', 'Bad Request')
@section('code', $exception->getStatusCode())
@section('message')
    <p>It seems there are some technical problems.</p>
    <p>Please try again later.</p>
@endsection
@section('actions')
    <a href="{{ url()->previous(route('web.home.index')) }}" title="Go Back">Go Back</a>
@endsection
