@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate('SubCategory Information') }}</h5>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill border-light">
                        @foreach (\App\Models\Language::all() as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                                    href="{{ route('subcategories.edit', ['id' => $subCategory->id, 'lang' => $language->code]) }}">
                                    <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"
                                        height="11" alt="" class="mr-1">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <form class="p-4" action="{{ route('subcategories.update', $subCategory->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Name') }} <i
                                    class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-md-9">
                                <input type="text" name="name"
                                    value="{{ $subCategory->getTranslation('name', $lang) }}"
                                    class="form-control @error('name')
                                        is-invalid
                                    @enderror"
                                    id="name" placeholder="{{ translate('Name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Parent Category') }}</label>
                            <div class="col-md-9">
                                <select
                                    class="select2 form-control aiz-selectpicker @error('category_id')
                                        is-invalid
                                    @enderror"
                                    name="category_id" data-toggle="select2" data-placeholder="Choose ..."
                                    data-live-search="true" data-selected="{{ $subCategory->parent_id }}">
                                    {{-- <option value="0">{{ translate('No Parent') }}</option> --}}
                                    @foreach ($categories as $acategory)
                                        <option value="{{ $acategory->id }}"
                                            {{ $acategory->id == $subCategory->category_id ? 'selected' : '' }}>
                                            {{ $acategory->getTranslation('name') }}
                                        </option>
                                        {{-- @foreach ($acategory->childrenCategories as $childCategory)
                                            @include('categories.child_category', [
                                                'child_category' => $childCategory,
                                            ])
                                    @endforeach --}}
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Featured') }}</label>
                            <div class="col-md-3">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="update_featured(this)" value="{{ $acategory->id }}"
                                        <?php if ($acategory->featured == 1) {
                                            echo 'checked';
                                        } ?>>
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
                                        value="{{ $subCategory->banner }}">
                                    @error('banner')
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
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Icon') }}
                                <small>({{ translate('32x32') }})</small></label>
                            <div class="col-md-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="icon"
                                        class="selected-files @error('icon')
                                        is-invalid
                                    @enderror"
                                        value="{{ $subCategory->icon }}">
                                    @error('icon')
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
                            <label class="col-md-3 col-form-label">{{ translate('Meta Title') }}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="meta_title"
                                    value="{{ $subCategory->meta_title }}" placeholder="{{ translate('Meta Title') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Meta Description') }}</label>
                            <div class="col-md-9">
                                <textarea name="meta_description" rows="5" class="form-control">{{ $subCategory->meta_description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Slug') }}</label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('Slug') }}" id="slug"
                                    name="slug" value="{{ $subCategory->slug }}" class="form-control">
                            </div>
                        </div>
                        @if (get_setting('category_wise_commission') == 1)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Commission Rate') }}</label>
                                <div class="col-md-9 input-group">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        id="commision_rate" name="commision_rate"
                                        value="{{ $subCategory->commision_rate }}" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
