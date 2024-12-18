@extends('new.layout')



@section('content')

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a>
                        <span>Verify Your Email Address</span>
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

                        <h1 class="h3 fw-600 mb-3">{{ translate('Verify Your Email Address') }}</h1>
                        <p class="opacity-60">
                            {{ translate('Before proceeding, please check your email for a verification link.') }}
                            {{ translate('If you did not receive the email.') }}
                        </p>
                        <a href="{{ route('verification.resend') }}" class="btn btn-primary btn-block">{{ translate('Click here to request another') }}</a>
                        @if (session('resent'))
                            <div class="alert alert-success mt-2 mb-0" role="alert">
                                {{ translate('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')


    <script src="{{asset('new')}}/js/jquery-3.3.1.min.js"></script>



@endsection
