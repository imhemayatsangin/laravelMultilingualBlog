@extends('layouts.app')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('posts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.post.title_singular') }}
            </a>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.post.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Post">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.post.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.main_title') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.language') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $key => $post)
                        <tr data-entry-id="{{ $post->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $post->id ?? '' }}
                            </td>
                            <td>
                                {{ $post->main_title ?? '' }}
                            </td>
                            <td>
                                {{ $post->user->name ?? '' }}
                            </td>
                            <td>
                                @foreach($post->languages as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                              
                                    <a class="btn btn-xs btn-primary" href="{{ route('posts.show', $post->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                            

                            
                                    <a class="btn btn-xs btn-info" href="{{ route('posts.edit', $post->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                

                               
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>

                                    <a class="btn btn-xs btn-success" href="#">
                                        {{ trans('global.translate') }}
                                    </a>

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