@extends('frontend.layout')

@section('content')

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a>
                        <span>Reset Password</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                        <h2>Reset Password</h2>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf



                            <div class="group-input">
                                <label for="username">Email address *</label>

                                <input id="email"
                                       type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autocomplete="email"
                                       autofocus id="username">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror



                            </div>





                            <button type="submit" class="site-btn register-btn">Send Password Reset Link</button>
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
