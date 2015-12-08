@extends('layouts.master')
@section('content')
  <div class="row">
    <div class="col-lg-6 col-lg-offset-2">
      <ul class="nav nav-pills">
        <li role="presentation" class="{{ Request::input('where') == "posts" ? "active" : "" ; }}"><a href="{{ Config::get('app.url') }}/search?q={{ Request::input('q') }}&where=posts">Gönderiler</a></li>
        <li role="presentation" class="{{ Request::input('where') == "subtitles" ? "active" : "" ; }}"><a href="{{ Config::get('app.url') }}/search?q={{ Request::input('q') }}&where=subtitles">Alt Başlıklar</a></li>
      </ul>
    </div>
  </div>
  @if(Request::input('where') == 'subtitles')

  @foreach($query as $subtitle)
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>{{ HTML::linkRoute('subtitle', $subtitle->name, [$subtitle->slug], []) }}</h1><br />
            <p>{{ $subtitle->description }}</p>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  @elseif(Request::input('where') == 'posts')
  @foreach($query as $post)
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
  @else
  <div class="row">
    <div class="col-lg-8 col-lg-offset-2">
      <div class="panel panel-default">
        <div class="panel-body text-center">
          <h2>Kategori Seçiniz</h2>
        </div>
      </div>
    </div>
  </div>
  @endif


  @if($query->getTotal() > 30)
    <div class="row">
      <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-default">
          <div class="panel-body">{{ $query->links() }}</div>
        </div>
      </div>
    </div>
  @endif
@stop
