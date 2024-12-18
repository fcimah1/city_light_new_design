@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate($method->name . ' Information') }}</h5>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill border-light">
                        @foreach (\App\Models\Language::all() as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                                    href="{{ route('payment_methods.edit', ['id' => $method->id, 'lang' => $language->code]) }}">
                                    <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"
                                        height="11" alt="" class="mr-1">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <form class="p-4" action="{{ route('payment_methods.update', $method->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Name') }} <i
                                    class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ $method->name }}" class="form-control"
                                    id="name" placeholder="{{ translate('Name') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Fees') }}
                                <i class="las la-language text-danger" title="{{ translate('Translatable') }}"></i>
                            </label>
                            <div class="col-md-9">
                                <input type="number" step="0.01" name="fees" value="{{ $method->fees }}"
                                    class="form-control" id="fees" placeholder="{{ translate('Fees') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Status') }}</label>
                            <div class="col-md-3">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="status" value="1"
                                        {{ $method->status == 'active' ? 'checked' : ' ' }}>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Icon') }}
                                <small>({{ translate('32x32') }})</small></label>
                            <div class="col-md-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="icon" class="selected-files"
                                        value="{{ $method->icon }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                        {{-- public key --}}
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Public Key') }}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="public_key"
                                    value="{{ $method->public_key }}" placeholder="{{ translate('Public Key') }}">
                            </div>
                        </div>
                        {{-- Secret key --}}
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Private Key') }}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="secret_key"
                                    value="{{ $method->secret_key }}" placeholder="{{ translate('Secret Key') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Merchant ID') }}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="marchent_code"
                                    value="{{ $method->marchent_code }}" placeholder="{{ translate('Marchent Code') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Meta Title') }}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="meta_title"
                                    value="{{ $method->meta_title }}" placeholder="{{ translate('Meta Title') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Meta Description') }}</label>
                            <div class="col-md-9">
                                <textarea name="meta_description" rows="5" class="form-control">{{ $method->meta_description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
