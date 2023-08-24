@extends('layouts.mail')

@section('body')
    <h1>Hello {{ $user->name }}</h1>
    <code>
        <a href="{{ $_ENV['APP_URL'] }}/password/reset?token={{ $token->token }}">
            {{ $_ENV['APP_URL'] }}/password/reset?token={{ $token->token }}
        </a>
    </code>
@endsection
