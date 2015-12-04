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
      <small>
        {{ HTML::linkRoute('subtitle.delete', 'Sayfayı Sil', [$subtitle->id], []) }}
      </small>
    @endif
  @endif
</h1>
<hr />
<p>
  <ul class="post-list">
  @foreach($subtitle->posts()->where("isComment",0)->get() as $post)
  <li class="post-list-item @if($post->isLink != null ) link @endif">
    @if(Auth::check())
    {{ HTML::linkRoute('vote', '[+]', [$post->id,1], []) }} -
    {{ HTML::linkRoute('vote', '[-]', [$post->id,0], []) }} -
    @endif
    @if($post->isLink != null )
      <a href="{{ $post->isLink }}">{{ $post->title }}</a>
    @else
      {{ HTML::linkRoute('post.view', $post->title, [$subtitle->slug,$post->id], []) }}
    @endif
    {{ $post->positiveVotes()->count() - $post->negativeVotes()->count() }} / {{ $post->votes()->count() }} -
    <small>
      {{ HTML::linkRoute('post.view', 'Yorumlar', [$subtitle->slug,$post->id], []) }}
    </small>
    @if(Auth::check())
      @if($post->user_id == Auth::user()->id)
         - <small>
           {{ HTML::linkRoute('post.delete', 'Gönderiyi Sil', [$post->id], []) }}
         </small>
      @endif
    @endif
  @endforeach
  </ul>
</p>
<hr />
<p>
{{ HTML::linkRoute('post.create', 'Yeni Gönder', [$subtitle->slug], ['class' => 'btn btn-success btn-md']) }}
</p>
@stop
