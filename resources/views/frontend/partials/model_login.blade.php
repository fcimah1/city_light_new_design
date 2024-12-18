<div class="modal fade" id="login-modal">
    <div class="modal-dialog modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-600">{{ __('front.Login') }}</h6>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-3">
                    <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                        @csrf
                        {{--                            @if (addon_is_activated('otp_system') && env('DEMO_MODE') != 'On')--}}
                        {{--                                <div class="form-group phone-form-group mb-1">--}}
                        {{--                                    <input type="tel" id="phone-code"--}}
                        {{--                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"--}}
                        {{--                                        value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">--}}
                        {{--                                </div>--}}

                        {{--                                <input type="hidden" name="country_code" value="">--}}

                        {{--                                <div class="form-group email-form-group mb-1 d-none">--}}
                        {{--                                    <input type="email"--}}
                        {{--                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"--}}
                        {{--                                        value="{{ old('email') }}" placeholder="{{ __('front.Email') }}" name="email"--}}
                        {{--                                        id="email" autocomplete="off">--}}
                        {{--                                    @if ($errors->has('email'))--}}
                        {{--                                        <span class="invalid-feedback" role="alert">--}}
                        {{--                                            <strong>{{ $errors->first('email') }}</strong>--}}
                        {{--                                        </span>--}}
                        {{--                                    @endif--}}
                        {{--                                </div>--}}

                        {{--                                <div class="form-group text-right">--}}
                        {{--                                    <button class="btn btn-link p-0 opacity-50 text-reset" type="button"--}}
                        {{--                                        onclick="toggleEmailPhone(this)">{{ __('front.Use Email Instead') }}</button>--}}
                        {{--                                </div>--}}
                        {{--                            @else--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <input type="email"--}}
                        {{--                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"--}}
                        {{--                                        value="{{ old('email') }}" placeholder="{{ __('front.Email') }}" name="email"--}}
                        {{--                                        id="email" autocomplete="off">--}}
                        {{--                                    @if ($errors->has('email'))--}}
                        {{--                                        <span class="invalid-feedback" role="alert">--}}
                        {{--                                            <strong>{{ $errors->first('email') }}</strong>--}}
                        {{--                                        </span>--}}
                        {{--                                    @endif--}}
                        {{--                                </div>--}}
                        {{--                            @endif--}}


                        <div class="form-group">
                            <input type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   value="{{ old('email') }}" placeholder="{{ __('front.Email') }}" name="email"
                                   id="email" autocomplete="off">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="password"
                                   class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   placeholder="{{ __('front.Password') }}" name="password" id="password">
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label class="aiz-checkbox">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span class=opacity-60>{{ __('front.Remember Me') }}</span>
                                    <span class="aiz-square-check"></span>
                                </label>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('password.request') }}"
                                   class="text-reset opacity-60 fs-14">{{                                  __('front.Forgot password?') }}</a>
                            </div>
                        </div>

                        <div class="mb-5">
                            <button type="submit"
                                    class="btn btn-primary btn-block fw-600">{{  __('front.Login') }}</button>
                        </div>
                    </form>

                </div>
                <div class="text-center mb-3">
                    <p class="text-muted mb-0">{{ __('front.Dont have an account?') }}</p>
                    <a href="{{ route('register') }}">{{ __('front.Register Now') }}</a>
                </div>
                @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1)
                    <div class="separator mb-3">
                        <span class="bg-white px-3 opacity-60">{{ __('front.Or Login With') }}</span>
                    </div>
                    <ul class="list-inline social colored text-center mb-3">
                        @if (get_setting('facebook_login') == 1)
                            <li class="list-inline-item">
                                <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                   class="facebook">
                                    <i class="lab la-facebook-f"></i>
                                </a>
                            </li>
                        @endif
                        @if (get_setting('google_login') == 1)
                            <li class="list-inline-item">
                                <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                   class="google">
                                    <i class="lab la-google"></i>
                                </a>
                            </li>
                        @endif
                        @if (get_setting('twitter_login') == 1)
                            <li class="list-inline-item">
                                <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                   class="twitter">
                                    <i class="lab la-twitter"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
