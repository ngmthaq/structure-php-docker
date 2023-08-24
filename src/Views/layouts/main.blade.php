@extends('layouts.base')

@push('meta')
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="{{ AUTHOR }}">
    <meta name="{{ XSRF_KEY }}" content="{{ $_SESSION[XSRF_KEY] }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:url" content="{{ Common::getCurrentUrl() }}">
    <meta property="og:image" content="@yield('image')">
    <meta property="og:description" content="@yield('description')">
    <meta property="business:contact_data:street_address" content="{{ STREET_ADDRESS }}">
    <meta property="business:contact_data:country_name" content="{{ COUNTRY }}">
@endpush
