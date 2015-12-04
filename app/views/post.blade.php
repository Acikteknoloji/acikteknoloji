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
@if(Auth::user()->isAdminOn($subtitle->id) && isset($_GET['p']))
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
<div class="panel panel-default">
  <div class="panel-heading">
<h2>{{ $post->title }}  - <small>{{ $post->user->username }} {{ HTML::linkRoute('vote', '[+]', [$post->id,1], []) }} -
{{ HTML::linkRoute('vote', '[-]', [$post->id,0], []) }} -
{{ $post->positiveVotes()->count() - $post->negativeVotes()->count() }} / {{ $post->votes()->count() }}</small></h2></div>
<div class="panel-body">
<div class="post-content">{{ Markdown::parse($post->content) }}</div>
</div>
@if(Auth::check())
  @if($post->user_id == Auth::user()->id)
<div class="panel-footer text-right">
  <span class="post-links">
    {{ HTML::linkRoute('post.delete', 'Gönderiyi Sil', [$post->id], ['class' => 'post-link']) }} |
     {{ HTML::linkRoute('post.edit', 'Gönderiyi Düzenle', [$post->id], ['class' => 'post-link']) }}
  </span>
</div>
  @endif
@endif
</div>
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
  @if(Auth::check())
  <div class="panel panel-info">
    <div class="panel-heading text-center">Yorum Yap</div>
    <div class="panel-body">
  {{ Form::open(['post.comment']) }}
    {{ Form::textarea('content',null,['class' => 'form-control','placeholder' => 'Yorum','data-uk-htmleditor' => '{markdown:true}']) }}<br />
    {{ Form::hidden('comment_id',$post->id) }}
    </div>
    <div class="panel-footer">
    {{ Form::submit('Yorum yap',['class' => 'btn btn-lg btn-info'] )}}
  {{ Form::close() }}
    </div>
  </div>
  @endif
@stop
