@extends('layouts.welcome')

@section('content')
<div class="container">
 @foreach($posts as $post)

{{ $post->main_title }}
<p>Published By: 
{{ $post->user->name }}
</p>
 @endforeach

</div>
@endsection
