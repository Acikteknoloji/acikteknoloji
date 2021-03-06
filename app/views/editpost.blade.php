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

.comment:nth-child(even) { background-color:#eee; }
.comment:nth-child(odd)  {background: #ddd; }
.comment{
  padding:5px;
  margin-top:8px;
}
  .comment .comment {
    padding-left:40px;
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
@if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif
{{ Form::open() }}
  {{ Form::text('title',$post->title,['class' => 'form-control','placeholder' => 'Burayı düzenlemenize gerek yok']) }}<br />
  {{ Form::textarea('content',$post->content,['class' => 'form-control','placeholder' => 'Gönderi','data-uk-htmleditor' => '{markdown:true}']) }}<br />
  {{ Form::submit('Gönderiyi düzenle',['class' => 'btn btn-lg btn-success'] )}}
{{ Form::close() }}<br />
@stop
