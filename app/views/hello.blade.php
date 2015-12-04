@extends('layouts.master')
@section('content')
		<h1>Tüm Alt Başlıklar</h1>
		@foreach($subtitles as $subtitle)
			<h2><a href="{{ Request::root() }}/s/{{ $subtitle->slug}}">{{ $subtitle->name }}</a>
			</h2>
		@endforeach
		{{ $subtitles->links() }}
		<hr />
		<h1>Son 30 Konu</h1>
		<p>
			<ul>
				@foreach($posts as $post)
					<li><strong>{{ $post->subtitle->name }}</strong> üzerine <strong>{{ $post->user->username }}</strong> tarafından: <a href="{{ Request::root() }}/s/{{ $post->subtitle->slug }}/p/{{ $post->id }}">{{ $post->title }}</a></li>
				@endforeach
			</ul>
		</p>
@stop
