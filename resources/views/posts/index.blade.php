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

        <table class="table">
            <thead>
              <tr class="table-active">
                <th width="10">
                    @
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
                   Actions
                </th>
              </tr>
            </thead>
            <tbody>
              <tr class="table-default toggle-row">
                <td class="toggle-btn"><strong>  <i class="fas fa-plus custom-icon"></i></strong></td>
                <td>Data 2</td>
                <td> Data 3</td>
                <td> Data 4</td>
                <td> Data 5</td>
                <td> Data 6</td>
              </tr>
              <tr class="table-success sub-row ">
                <th style="background-color: #ffffff;">&nbsp;</th>
                <th>Language</th>
                <th>Title</th>
                <th>publish Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <tr class="table-info sub-row ">
                <td style="background-color: #ffffff;">&nbsp;</td>
                <td>Data 1</td>
                <td>Data 2</td>
                <td>Data 3</td>
                <td>Data 4</td>
                <td>Data 5</td>
              </tr>
              <!-- Add more rows with sub-rows here -->
              <tr class="table-default toggle-row">
                <td class="toggle-btn"><strong>  <i class="fas fa-plus custom-icon"></i></strong></td>
                <td>Data 2</td>
                <td> Data 3</td>
                <td> Data 4</td>
                <td> Data 5</td>
                <td> Data 6</td>
              </tr>
              <tr class="table-success sub-row ">
                <th style="background-color: #ffffff;">&nbsp;</th>
                <th>Language</th>
                <th>Title</th>
                <th>publish Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <tr class="table-info sub-row ">
                <th style="background-color: #ffffff;">&nbsp;</th>
                <td>Data 1</td>
                <td>Data 2</td>
                <td>Data 3</td>
                <td>Data 4</td>
                <td>Data 5</td>
              </tr>
            </tbody>
          </table>

    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(document).ready(function() {
    
        $(".sub-row").hide();
    
        $(".toggle-row").click(function() {
            var clickedRow = $(this).closest("tr");
            var subRows = clickedRow.nextUntil(".toggle-row");
            var toggleBtn = $(this).find(".toggle-btn");
    
            // Close all previously opened rows
            $(".sub-row").not(subRows).hide();
            $(".toggle-row .toggle-btn").not(toggleBtn).html('<i class="fas fa-plus custom-icon"></i>');
    
            // Toggle visibility of the clicked row's sub-rows
            subRows.toggle();
        
            if (subRows.is(":visible")) {
                toggleBtn.html('<i class="fas fa-minus custom-icon"></i>');
            } else {
                toggleBtn.html('<i class="fas fa-plus custom-icon"></i>');
            }
        });
    });
    </script>
@endsection