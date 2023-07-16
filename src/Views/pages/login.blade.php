@extends('layouts.base')

@section('title', 'Login')

@section('description', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit.')

@section('keywords', 'PHP')

@section('base-content')
    <form action="/login" method="post">
        <h1>{{ Lang::t('login') }}</h1>
        <input type="hidden" name="back_url" value="{{ $params['back_url'] }}">
        <input type="email" name="email" id="email" placeholder="{{ Lang::t('email') }}"><br>
        <small>{{ $flash_messages['email'] }}</small><br>
        <input type="password" name="password" id="password" placeholder="{{ Lang::t('password') }}"><br>
        <small>{{ $flash_messages['password'] }}</small><br>
        <input type="checkbox" name="is_remember" id="is_remember">
        <label for="is_remember">Is Remember?</label><br>
        <button type="submit">Login</button>
    </form>
@endsection
