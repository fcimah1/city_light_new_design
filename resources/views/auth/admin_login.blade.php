@extends('frontend.layout')

@section('content')


    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a>
                        <span>Admin Login</span>
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
                        <h2>Admin Login</h2>
                        <form class="form-default" role="form" action="{{ route('admin.login') }}" method="POST">
                              @csrf
                            <div class="group-input">
                                <label for="username">email address *</label>

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

                            <button type="submit" class="site-btn login-btn">Sign In</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection



@section('script')


    <script src="{{asset('new')}}/js/jquery-3.3.1.min.js"></script>







@endsection
