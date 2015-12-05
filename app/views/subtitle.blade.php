@extends('layouts.master')
@section('extra.style')
@if(Auth::check())
@if(Auth::user()->isAdminOn($subtitle->id) && isset($_GET['p']))
{{ $subtitle->unvalidcustomcss }}
@else
{{ $subtitle->customcss }}
@endif
@else
{{ $subtitle->customcss }}
@endif
@stop
@section('content')
<h1>{{ $subtitle->name }}<small> @if(Auth::check()) @if(Auth::user()->isAdminOn($subtitle->id)) Admin @endif @endif </small> <br /><small>{{ $subtitle->description }}</h1>
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
<span class="pull-left">{{ HTML::linkRoute('post.create', 'Yeni Gönder', [$subtitle->slug], ['class' => 'btn btn-success btn-md']) }}</span>
@if(Auth::check())
<span class="pull-right">
  @if(DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->exists())
    {{ HTML::linkRoute('subtitle.signout','Üyelikten Çık',[$subtitle->slug],['class' => 'btn btn-danger btn-md']) }} 
    @if(DB::Table('user_subtitle')->where('subtitle_id',$subtitle->id)->where('user_id',Auth::user()->id)->where('isAdmin','=',1)->exists())
    {{ HTML::linkRoute('subadmin.home','Yönetici Paneli',[$subtitle->slug],['class' => 'btn btn-default btn-md']) }}
    @endif
  @else
    {{ HTML::linkRoute('subtitle.signup','Üye Ol',[$subtitle->slug],['class' => 'btn btn-info btn-md']) }}
  @endif
</span>
@endif
</p>
@stop
