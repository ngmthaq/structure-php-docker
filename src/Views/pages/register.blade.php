@extends('layouts.base')

@section('title', 'Register')

@section('description', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit.')

@section('keywords', 'PHP')

@push('css')
    <style>
        .wrap {
            width: 100%;
            overflow: hidden;
            background: #fff;
            border-radius: 5px;
            -webkit-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
            -moz-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
            box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
        }

        .wrap .img {
            height: 200px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .login-wrap {
            position: relative;
        }
    </style>
@endpush

@section('base-content')
    <div class="container">
        <div class="row justify-content-center align-content-center h-100vh">
            <div class="col-4">
                <div class="wrap">
                    <div class="img" style="background-image: url(/img/login-background.jpg);"></div>
                    <div class="login-wrap p-4">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-2">Sign Up</h3>
                            </div>
                            <div class="w-100">
                                <p class="social-media d-flex justify-content-end">
                                    <a href="#" class="social-icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-facebook"></span>
                                    </a>
                                    <a href="#" class="social-icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-twitter"></span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <form action="/register" method="post" class="signin-form" autocomplete="on">
                            {{ csrf() }}
                            <div class="form-group mt-3">
                                <label class="form-label required" for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            @if (isset($flash_messages['name']))
                                <small class="text-danger">{{ $flash_messages['name'] }}</small>
                            @endif
                            <div class="form-group mt-3">
                                <label class="form-label required" for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                            @if (isset($flash_messages['email']))
                                <small class="text-danger">{{ $flash_messages['email'] }}</small>
                            @endif
                            <div class="form-group mt-3">
                                <label class="form-label required" for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password"
                                    data-toggle-password="on">
                            </div>
                            @if (isset($flash_messages['password']))
                                <small class="text-danger">{{ $flash_messages['password'] }}</small>
                            @endif
                            <div class="form-group my-4">
                                <button type="submit" class="form-control btn btn-primary px-3">
                                    Sign Up
                                </button>
                            </div>
                        </form>
                        <p class="text-center">Have an account? <a data-toggle="tab" href="/login">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
