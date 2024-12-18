@extends('frontend.layout')

@section('content')

    <div class="breacrumb-section banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a>
                        <span>Register</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                        <h2>Register</h2>
                        <form id="reg-form" class="form-default" role="form" action="{{ route('register') }}" method="POST">

                            @csrf

                            <div class="group-input">
                                <label for="name">Name *</label>

                                <input type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}"
                                       name="name" id="name" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                @endif
                            </div>

                            <div class="group-input">
                                <label for="username">Email address *</label>

                                <input type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       value="{{ old('email') }}"
                                       placeholder="{{  translate('Email') }}"
                                       name="email" id="username" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>


                            <div class="group-input">
                                <label for="pass">Password *</label>

                                <input type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       placeholder="{{  translate('Password') }}"
                                       name="password" id="pass" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            </div>


                            <div class="group-input">
                                <label for="con-pass">Confirm Password *</label>
                                <input type="password"
                                       class="form-control"
                                       placeholder="{{  translate('Confirm Password') }}"
                                       name="password_confirmation" id="con-pass" required>
                            </div>

                            <div class="group-input">
                                <label for="term">Agree Our Term * </label>


                                <label class="aiz-checkbox">
                                    <input type="checkbox" name="checkbox_example_1" required>
                                    <span class="opacity-60">By signing up you agree to our

                                      <a style="font-weight: bold;color: orange" href="{{url('Terms-of-service')}}" target="_blank">Term Of Service.</a>
                                    </span>
                                    <span class="aiz-square-check"></span>
                                </label>
                            </div>



                            <button type="submit" class="site-btn register-btn">REGISTER</button>
                        </form>
                        <div class="switch-login">
                            <a href="{{url('login')}}" class="or-login">Or Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


@section('script')


    <script src="{{asset('new')}}/js/jquery-3.3.1.min.js"></script>



@endsection
