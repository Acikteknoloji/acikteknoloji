@extends('layouts.master')
@section('extra.style')
@if(Auth::check())
@if(Auth::user()->id == $subtitle->user_id && isset($_GET['p']))
{{ $subtitle->unvalidcustomcss }}
@else
{{ $subtitle->customcss }}
@endif
@else
{{ $subtitle->customcss }}
@endif
@stop
@section('content')
<h1>{{ $subtitle->name }} <br /><small>{{ $subtitle->description }}
  @if(Auth::check())
    @if($subtitle->user_id == Auth::user()->id)
      <small><a href="{{ Request::root() }}/subtitle/delete/{{ $subtitle->id }}">Sayfayı Sil</a></small>
    @endif
  @endif
</h1>
<hr />
<p>
  <ul class="post-list">
  @foreach($subtitle->posts()->where("isComment",0)->get() as $post)
  <li class="post-list-item @if($post->isLink != null ) link @endif">
    @if(Auth::check())
    <a href="{{ Request::root() }}/vote/{{ $post->id }}/1">[+]</a> -
    <a href="{{ Request::root() }}/vote/{{ $post->id }}/0">[-]</a> -
    @endif
    @if($post->isLink != null )
      <a href="{{ $post->isLink }}">{{ $post->title }}</a>
    @else
      <a href="{{ Request::root() }}/s/{{ $subtitle->slug }}/p/{{ $post->id }}">{{ $post->title }}</a>
    @endif
    {{ $post->positiveVotes()->count() - $post->negativeVotes()->count() }} / {{ $post->votes()->count() }} -
    <small><a href="{{ Request::root() }}/s/{{ $subtitle->slug }}/p/{{ $post->id }}">Yorumlar</a></small>
    @if(Auth::check())
      @if($post->user_id == Auth::user()->id)
         - <small><a href="{{ Request::root() }}/post/delete/{{ $post->id }}">Gönderiyi Sil</a></small>
      @endif
    @endif
  @endforeach
  </ul>
</p>
<hr />
<p><a href="{{ Request::root() }}/s/{{ $subtitle->slug }}/post/create" class="btn btn-success btn-md">Yeni Gönder</a></p>
@stop
