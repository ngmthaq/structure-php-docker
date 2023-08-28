@extends('layouts.main')

@section('title', 'Reset Password')

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

@section('body')
    <div class="container">
        <div class="row justify-content-center align-content-center h-100vh">
            <div class="col-lg-4 col-md-7 col-sm-10 col-12">
                <div class="wrap">
                    <div class="img" style="background-image: url(/img/login-background.jpg);"></div>
                    <div class="login-wrap p-4">
                        <div class="w-100">
                            <h3 class="mb-2">Reset Password</h3>
                        </div>
                        <form action="/password/reset" method="post" class="signin-form" autocomplete="on">
                            {{ csrf() }}
                            {{ put() }}
                            <input type="hidden" name="token" value="{{ $params['token'] }}">
                            <div class="form-group mt-3">
                                <label class="form-label required" for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            @if (isset($flash_messages['password']))
                                <small class="text-danger">{{ $flash_messages['password'] }}</small>
                            @endif
                            <div class="form-group mt-3">
                                <label class="form-label required" for="password-confirmation">Password confirmation</label>
                                <input type="password" class="form-control" id="password-confirmation"
                                    name="password-confirmation">
                            </div>
                            @if (isset($flash_messages['password-confirmation']))
                                <small class="text-danger">{{ $flash_messages['password-confirmation'] }}</small>
                            @endif
                            <div class="form-group my-3">
                                <button type="submit" class="form-control btn btn-primary px-3">
                                    Reset password
                                </button>
                            </div>
                        </form>
                        <p class="text-center">
                            Not a member?
                            <a data-toggle="tab" href="/register">Sign Up</a>
                            Or
                            <a data-toggle="tab" href="/login">Sign In</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
