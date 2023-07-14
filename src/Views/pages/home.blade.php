@extends('layouts.base')

@section('title', 'Homepage')

@section('description', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit.')

@section('keywords', 'PHP')

@section('base-content')
    <h1>Hello {{ Auth::user()->name }}</h1>
    <form action="/logout" method="post">
        <button type="submit">Logout</button>
    </form>
@endsection
