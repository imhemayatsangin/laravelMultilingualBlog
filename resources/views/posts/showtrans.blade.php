@extends('layouts.app')
@section('content')

<div class="card">
    <div class="card-header">
    Show Translation
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-success" href="{{ route('posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a><br><br>
            </div>
            <div class="container">
                <h6>post translation Details</h6>
                @if ($data)
                    <p><strong>Post main title:</strong> {{ $data->main_title }}</p>
                    <p><strong>Language:</strong> {{ $data->name }}</p>
                    <p><strong>Title:</strong> {{ $data->title }}</p>


                    <p><strong>Content:</strong></p>
                   
                        <pre>{!!  $data->content !!}</pre>
                   
        
               
                    <p><strong>Publish Date:</strong> {{ $data->publish_date }}</p>
                    <p><strong>Publish Time:</strong> {{ $data->publish_time }}</p>
                    <p><strong>Status:</strong> {{ $data->status ? 'Published' : 'Un Published' }}</p>
                @else
                    <p>No matching language post found.</p>
                @endif
            </div>
            <div class="form-group">
                <a class="btn btn-success" href="{{ route('posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection


@section('scripts')
<script>
    $(document).ready(function () {
// 
function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('posts.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $post->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection