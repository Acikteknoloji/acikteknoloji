@extends('layouts.master')
@section('extra.head')
{{ HTML::Style('css/uikit.min.css') }}
{{ HTML::Script('js/uikit.min.js') }}
{{ HTML::Style('codemirror/lib/codemirror.css') }}
{{ HTML::Script('codemirror/lib/codemirror.js') }}
{{ HTML::Script('codemirror/mode/markdown/markdown.js') }}
{{ HTML::Script('codemirror/addon/mode/overlay.js') }}
{{ HTML::Script('codemirror/mode/xml/xml.js') }}
{{ HTML::Script('js/marked.js') }}

{{ HTML::Style('css/components/htmleditor.css') }}
{{ HTML::Script('js/components/htmleditor.js')}}
@stop
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

.comment:nth-child(even) { background-color:#eaeaea; }
.comment:nth-child(odd)  {background: #d0d0d0; }
.comment{
  padding:5px;
  margin-top:8px;
}
  .comment .comment {
    padding-left:40px;
  }
.comment-reply
{
  padding:30px;
  background-color:#fff;
  margin:10px;
}
.post-link{
  font-size:8pt;
  font-weight:200;
}

.uk-htmleditor-navbar-nav.uk-htmleditor-toolbar {
    display: none;
}
@stop
@section('content')
<h1><a href="{{ Request::root()}}/s/{{ $subtitle->slug }}">{{ $subtitle->name }}</a> <br /><small>{{ $subtitle->description }}</small></h1><br />
<h2>{{ $post->title }}  - <small>{{ $post->user->username }} <a href="{{ Request::root() }}/vote/{{ $post->id }}/1">[+]</a> -
<a href="{{ Request::root() }}/vote/{{ $post->id }}/0">[-]</a> -
{{ $post->positiveVotes()->count() - $post->negativeVotes()->count() }} / {{ $post->votes()->count() }}</small></h2>
<div class="post-content">{{ Markdown::parse($post->content) }}</div>
@if(Auth::check())
  @if($post->user_id == Auth::user()->id)
  <span class="post-links">
    <a class="post-link" href="{{ Request::root() }}/post/delete/{{ $post->id }}">Gönderiyi Sil</a> |
    <a class="post-link" href="{{ Request::root() }}/post/edit/{{ $post->id }}">Gönderiyi Düzenle</a>
  </span>
  @endif
@endif
<hr />
<p>
  @if(Post::where('isComment',$post->id)->count() > 0)
  @foreach(Post::where('isComment',$post->id)->get() as $comment)
    @include('partials.comment',['comment' => $comment])
  @endforeach
  @else
  <div class="row">
    <div class="col-lg-12 text-center">
      <h2>Hiç Yorum Yapılmamış!</h2>
    </div>
  </div>
  @endif
  <br />
  <div class="panel panel-info">
    <div class="panel-heading text-center">Yorum Yap</div>
    <div class="panel-body">
  @if(Session::has('comment_id'))
    Seçilen Yorum: {{ Post::where('id',Session::get('comment_id'))->first()->created_at }} tarihinde {{ Post::where('id',Session::get('comment_id'))->first()->user->username }} tarafından oluşturuldu <a href="{{ Request::root() }}/removecomment">[Seçimi Temizle]</a>
  @endif
  {{ Form::open() }}
    {{ Form::textarea('content',null,['class' => 'form-control','placeholder' => 'Yorum','data-uk-htmleditor' => '{markdown:true}']) }}<br />
    {{ Form::hidden('comment_id',$post->id) }}
    </div>
    <div class="panel-footer">
    {{ Form::submit('Yorum yap',['class' => 'btn btn-lg btn-info'] )}}
  {{ Form::close() }}
    </div>
  </div>
@stop
