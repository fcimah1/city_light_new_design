@extends('frontend.layout')

@section('content')


    <div class="breacrumb-section banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a>
                        <span>Login</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login-form">
                        <h2>Login</h2>
                        <form class="form-default" role="form" action="{{ route('login') }}" method="POST">
                              @csrf
                            <div class="group-input">
                                <label for="username">Username or email address *</label>

                                <input type="text"
                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       value="{{ old('email') }}"
                                       placeholder="{{  translate('Email') }}"
                                       name="email"
                                       id="username"
                                       autocomplete="off">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="group-input">
                                <label for="pass">Password *</label>

                                <input type="password"
                                       class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       placeholder="Password"
                                       name="password"
                                       id="pass">


                            </div>
                            <div class="group-input gi-check">
                                <div class="gi-more">
                                    <label for="save-pass">
                                        Save Password

                                        <input type="checkbox" id="save-pass" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                    <a href="{{url('password/reset')}}" class="forget-pass">Forget your Password</a>
                                </div>
                            </div>
                            <button type="submit" class="site-btn login-btn">Sign In</button>
                        </form>
                        <div class="switch-login">
                            <a href="{{url('register')}}" class="or-login">Or Create An Account</a>
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
