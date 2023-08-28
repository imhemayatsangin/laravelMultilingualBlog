@extends('layouts.app')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('languages.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.language.title_singular') }}
            </a>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.language.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Language">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.language.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.language.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.language.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.language.fields.icon') }}
                        </th>
                        <th>
                            {{ trans('cruds.language.fields.rtl') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($languages as $key => $language)
                        <tr data-entry-id="{{ $language->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $language->id ?? '' }}
                            </td>
                            <td>
                                {{ $language->name ?? '' }}
                            </td>
                            <td>
                                {{ $language->code ?? '' }}
                            </td>
                            <td>
                                {{ $language->icon ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $language->rtl ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $language->rtl ? 'checked' : '' }}>
                            </td>
                            <td>
                              
                                    <a class="btn btn-xs btn-primary" href="{{ route('languages.show', $language->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                               

                             
                                    <a class="btn btn-xs btn-info" href="{{ route('languages.edit', $language->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                            

                                    <form action="{{ route('languages.destroy', $language->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                              

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent

@endsection