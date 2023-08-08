@extends('layouts.mail')

@section('body')
    <h1>Welcome back {{ $user->name }}</h1>
@endsection
