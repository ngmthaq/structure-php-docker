@extends('layouts.base')

@section('title', 'Waiting for verify')

@section('description', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit.')

@section('keywords', 'PHP')

@section('body')
    <h2>You are not verified</h2>
    <form action="/logout" method="post">
        {{ csrf() }}
        <button type="submit">Logout</button>
    </form>
    <form action="/email/resent" method="post">
        {{ csrf() }}
        <button type="submit">Resent verify email</button>
    </form>
@endsection
                                                         