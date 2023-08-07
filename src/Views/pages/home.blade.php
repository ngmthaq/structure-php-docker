@extends('layouts.base')

@section('title', 'Homepage')

@section('description', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit.')

@section('keywords', 'PHP')

@section('base-content')
    <h1>{{ __('hello') }} {{ Auth::user()->name }}</h1>
    <form action="/logout" method="post">
        {{ csrf_input() }}
        <button type="submit">Logout</button>
    </form>
@endsection
