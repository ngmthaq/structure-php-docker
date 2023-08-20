@extends('layouts.base')

@section('title', 'Waiting for verify')

@section('description', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit.')

@section('keywords', 'PHP')

@section('base-content')
    <h1>{{ __('hello') }} {{ Auth::user()->name }}</h1>
    <h2>You are not verified</h2>
    <form action="/logout" method="post">
        {{ csrf() }}
        <button type="submit">Logout</button>
    </form>
@endsection
