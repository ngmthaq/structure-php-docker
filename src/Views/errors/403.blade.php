@extends('layouts.base')

@section('title', '403! Forbidden')

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
    <h1>403</h1>
    <p>
        <i>You don't have permission to access <?php echo Header::getFullUrl(); ?></i>
    </p>
@endsection
