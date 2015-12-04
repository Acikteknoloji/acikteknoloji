@extends('layouts.master')
@section('content')
		<h1>Tüm Alt Başlıklar</h1>
		@foreach($subtitles as $subtitle)
			<h2>
				{{ HTML::linkRoute('subtitle', $subtitle->name, [$subtitle->slug], array('class' => '')) }}
			</h2>
		@endforeach
		{{ $subtitles->links() }}
		<hr />
		<h1>Son 30 Konu</h1>
		<p>
			<ul>
				@foreach($posts as $post)
					<li><strong>{{ $post->subtitle->name }}</strong> üzerine <strong>{{ $post->user->username }}</strong> tarafından: {{ HTML::linkRoute('post.view', $post->title, [$post->subtitle->slug,$post->id], []) }}</li>
				@endforeach
			</ul>
		</p>
@stop
