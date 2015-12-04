@extends('layouts.master')
@section('content')
<ol>
@foreach($query as $item)
  @if($item->pid == null)
  <li><a href="{{ Request::root() }}/s/{{ $item->slug }}">Alt Başlık : {{ $item->name }}</a><br /><small>{{{ $item->description }}}</small></li>
  @else
  <li>
    @if($item->isComment == 0)
      <a href="{{ Request::root() }}/s/{{ $item->slug }}/p/{{ $item->pid }}">Gönderi: {{ $item->title }}</a><br />
      <small>{{ substr($item->content, 0, 255) }}...</small>
    @else
      <a href="{{ Request::root() }}/s/{{ $item->slug }}/p/{{ $item->isComment }}#{{ $item->pid }}">Yorum: {{ $item->created_at }}</a><br />
      <small>{{ substr($item->content, 0, 255) }}...</small>
    @endif
  </li>
  @endif
  <hr />
@endforeach
</ol>
@stop
