@extends('layouts.master')
@section('content')
@foreach($posts as $post)
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="panel panel-default">
				<div class="panel-body">
					<h1>{{ HTML::linkRoute('post.view', $post->title, [$post->subtitle->slug,$post->id], []) }}</h1><br />
					<p>{{ Markdown::parse(str_limit($post->content,250,'...')) }}</p>
				</div>
				<div class="panel-footer"><strong>Alt Başlık:</strong> {{ $post->subtitle->name }} <strong>Gönderen:</strong> {{ $post->user->username }} - Oy veren {{ $post->votes()->count() }} kişiden {{ $post->positiveVotes()->count() }} kişi bu gönderiyi beğendi</div>
			</div>
		</div>
	</div>
@endforeach
@if($posts->getTotal() > 30)
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">{{ $posts->links() }}</div>
			</div>
		</div>
	</div>
@endif
@stop
