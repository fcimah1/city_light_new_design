@extends('frontend.layouts.app')

@section('content')
    <div class="py-6">
        <div class="container">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-md-8 mx-auto">
                    <div class="bg-white rounded shadow-sm p-4 text-left">
                        <h1 class="h3 fw-600">{{ __('front.Reset Password') }}</h1>
                        <p class="mb-4 opacity-60">
                            {{ __('front.Enter your email address and new password and confirm password.') }} </p>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <div class="form-group">
                                <input id="email" type="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                    value="{{ $email ?? old('email') }}" placeholder="{{ __('front.Email') }}" required
                                    autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input id="code" type="text"
                                    class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code"
                                    value="{{ $email ?? old('code') }}" placeholder="{{ __('front.Code') }}" required
                                    autofocus>

                                @if ($errors->has('code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input id="password" type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password" placeholder="{{ __('front.New Password') }}" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" placeholder="{{ __('front.Confirm Password') }}"
                                    required>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('front.Reset Password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
