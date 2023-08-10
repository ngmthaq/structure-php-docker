@extends('layouts.base')

@section('title', 'Register')

@section('description', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit.')

@section('keywords', 'PHP')

@section('base-content')
    <form action="/register" method="post">
        {{ csrf() }}
        <h1>{{ __('register') }}</h1>
        <input type="input" name="email" id="email" placeholder="{{ __('email') }}"><br>
        <small>{{ $flash_messages['email'] }}</small><br>
        <input type="input" name="name" id="name" placeholder="{{ __('name') }}"><br>
        <small>{{ $flash_messages['name'] }}</small><br>
        <input type="password" name="password" id="password" placeholder="{{ __('password') }}"><br>
        <small>{{ $flash_messages['password'] }}</small><br>
        <button type="submit">Register</button>
    </form>
@endsection
