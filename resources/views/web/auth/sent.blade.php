@extends('skeleton')

@section('page')

    <p>We've sent a magic link to {{ $user ? $user->email : 'your email address' }}. Please click this link to sign in to your account.</p>

    <p>The link will expire in {{ config('widgets.magic-links.expiry-minutes') }} minutes.</p>

    <p><strong>Please check your email now.</strong></p>

@endsection