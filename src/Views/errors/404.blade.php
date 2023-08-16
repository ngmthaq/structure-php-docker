@extends('layouts.base')

@section('title', '404! Page not found')

@push('css')
    <style>
        #base-layout {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    </style>
@endpush

@section('base-content')
    <h1>404</h1>
    <p>
        <i>The page you are looking for was not found</i>
    </p>
@endsection
