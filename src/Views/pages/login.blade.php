@extends('layouts.base')

@section('title', 'Login')

@section('description', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit.')

@section('keywords', 'PHP')

@section('base-content')
    <form action="/login" method="post">
        <h1>Login</h1>
        <input type="email" name="email" id="email" placeholder="Email" required><br>
        <input type="password" name="password" id="password" placeholder="Password" required><br>
        <input type="checkbox" name="is_remember" id="is_remember">
        <label for="is_remember">Is Remember?</label><br>
        <button type="submit">Login</button>
    </form>
@endsection
