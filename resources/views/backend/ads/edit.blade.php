@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate('ads Information') }}</h5>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill border-light">
                        @foreach (\App\Models\Language::all() as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                                    href="{{ route('ads.edit', ['id' => $ad->id, 'lang' => $language->code]) }}">
                                    <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"
                                        height="11" alt="" class="mr-1">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <form class="p-4" action="{{ route('ads.update', $ad->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Name') }} <i
                                    class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ $ad->getTranslation('name', $lang) }}"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="{{ translate('Name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Link') }}</label>
                            <div class="col-md-9">
                                <input type="text" name="link" value="{{ $ad->link }}"
                                    class="form-control @error('link') is-invalid @enderror" id="link"
                                    placeholder="{{ translate('Link') }}">
                                @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Status') }}</label>
                            <div class="col-md-2 flex">
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="status" title="{{ translate('Active') }}"
                                            value="active" {{ $ad->status == 'active' ? 'checked' : '' }}>
                                        <span></span>

                                    </label>
                                    <span>{{ translate('Active') }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <label class="aiz-switch aiz-switch-danger mb-0">
                                        <input type="radio" name="status" title="{{ translate('InActive') }}"
                                            value="inactive" {{ $ad->status == 'inactive' ? 'checked' : '' }}>
                                        <span></span>
                                    </label>
                                    <span>{{ translate('Inactive') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Featured') }}</label>
                            <div class="col-md-3">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="featured" value="1"
                                        {{ $ad->featured ? 'checked' : ' ' }}>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Banner') }}
                                <small>(
                                    {{ translate('200x200') }}
                                    )</small></label>
                            <div class="col-md-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="banner"
                                        class="selected-files @error('banner')
                                        is-invalid
                                    @enderror"
                                        value="{{ $ad->banner }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('English Banner') }}
                                <small>(
                                    {{ translate('200x200') }}
                                    )</small></label>
                            <div class="col-md-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="english_banner"
                                        class="selected-files @error('english_banner')
                                        is-invalid
                                    @enderror"
                                        value="{{ $ad->english_banner }}">
                                    @error('english_banner')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Start Date') }}</label>
                            <div class="col-md-9">
                                <input type="datetime"
                                    class="form-control @error('start_date')
                                        is-invalid
                                    @enderror"
                                    id="start_date" name="start_date"
                                    value="{{ $ad->start_date }}" placeholder="{{ translate('Start Date') }}">
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('End Date') }}</label>
                            <div class="col-md-9">
                                <input type="datetime" class="form-control @error('end_date')
                                    is-invalid
                                @enderror" name="end_date" value="{{ $ad->end_date }}"
                                    placeholder="{{ translate('End Date') }}">
                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Meta Title') }}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="meta_title"
                                    value="{{ $ad->meta_title }}" placeholder="{{ translate('Meta Title') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Meta Description') }}</label>
                            <div class="col-md-9">
                                <textarea name="meta_description" rows="5" class="form-control">{{ $ad->meta_description }}</textarea>
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
