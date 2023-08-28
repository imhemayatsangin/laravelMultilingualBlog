@extends('layouts.app')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.language.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("languages.update", [$language->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.language.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $language->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.language.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="code">{{ trans('cruds.language.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $language->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.language.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="icon">{{ trans('cruds.language.fields.icon') }}</label>
                <input class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}" type="text" name="icon" id="icon" value="{{ old('icon', $language->icon) }}">
                @if($errors->has('icon'))
                    <div class="invalid-feedback">
                        {{ $errors->first('icon') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.language.fields.icon_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('rtl') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="rtl" value="0">
                    <input class="form-check-input" type="checkbox" name="rtl" id="rtl" value="1" {{ $language->rtl || old('rtl', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="rtl">{{ trans('cruds.language.fields.rtl') }}</label>
                </div>
                @if($errors->has('rtl'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rtl') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.language.fields.rtl_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection