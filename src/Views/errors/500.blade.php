@extends('layouts.base')

@section('title', '500! Error')

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

@section('base-content')
    <h1>500</h1>
    <p>
        <i>Oops! Some thing wrong, please try again later</i>
    </p>
@endsection
