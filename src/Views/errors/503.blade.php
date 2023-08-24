@extends('layouts.base')

@section('title', '503! Maintenance')

@push('css')
    <style>
        #layout {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    </style>
@endpush

@section('body')
    <h1>503</h1>
    <p>
        <i>The page was unable to load at this time</i>
    </p>
@endsection
