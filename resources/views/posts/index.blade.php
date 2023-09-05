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
  
        </div>

        <table class="table">
            <thead>
              <tr class="table-active">
                <th width="10">
                    Translations
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
                @foreach($posts as $key => $post)
              <tr  data-entry-id="{{ $post->id }}" class="table-default toggle-row">
                <td class="toggle-btn"><strong>  <i class="fas fa-plus custom-icon"></i></strong></td>
                <td>
                    {{ $post->id ?? '' }}
                </td>
                <td>  {{ $post->main_title ?? '' }}</td>
                <td>  {{ $post->user->name ?? '' }}</td>
                <td> 

                    @foreach($post->languages as $key => $item)
                    <span class="">{{ $item->name }}</span>
                    @endforeach

                </td>
                <td>

                    <a class="btn btn-xs btn-success" title="view" href="{{ route('posts.show', $post->id) }}">
                        <strong>  <i class="fas fa-eye "></i></strong>
                    </a>
            

            
                    <a class="btn btn-xs btn-warning" title="edit" href="{{ route('posts.edit', $post->id) }}">
                        <strong>  <i class="fas fa-edit "></i></strong>
                    </a>
                

               
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-xs btn-danger" title="delete"> <strong>  <i class="fas fa-trash "></i></strong></button>
                    </form>

                    <a class="btn btn-xs btn-info" href="{{ route('posts.translate', $post->id) }}" title="translate">
                        <strong>  <i class="fas fa-language "></i></strong>
                    </a>


                </td>
              </tr>
              <tr class="table-success sub-row ">
                <th style="background-color: #ffffff;">&nbsp;</th>
                <th>Language</th>
                <th>Title</th>
                <th>publish Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>


              @foreach($post->languages as $key => $item)
             

              <tr class="table-info sub-row ">
                <td style="background-color: #ffffff;">&nbsp;</td>
                <td> <span class="">{{ $item->name }}</span></td>
                <td>{{ $item->pivot->title }}</td>
                <td>{{ $item->pivot->publish_date }}</td>
                <td>{{ $item->pivot->status?"Published":"un-published" }}</td>
                <td>
                    <a class="btn btn-xs " href="{{ route('posts.showtrans', ['id' => $post->id, 'langid' => $item->pivot->language_id]) }}">
                        <strong>  <i class="fas fa-eye custom-btn"></i></strong>
                    </a>
                    <a class="btn btn-xs" href="{{ route('posts.edittrans', ['id' => $post->id, 'langid' => $item->pivot->language_id]) }}">
                        <strong>  <i class="fas fa-edit custom-btn"></i></strong>
                    </a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-xs "><strong>  <i class='fas fa-trash custom-btn'></i></strong></button>
                    </form>
                
                </td>
              </tr>


              @endforeach


          
              <!-- Add more rows with sub-rows here -->
  
    
              @endforeach
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