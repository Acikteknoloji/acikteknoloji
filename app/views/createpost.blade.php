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
@if ($errors->count() > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif
        @if(isset($lorc))
        <div class="alert alert-danger">
          {{ $lorc }}
        </div>
        @endif
{{ Form::open() }}
  {{ Form::text('title',Input::old('title'),['class' => 'form-control','placeholder' => 'Gönderi Başlığı']) }}<br />
  {{ Form::text('link',Input::old('link'),['class' => 'form-control','placeholder' => 'Link gönderisi ise link(http://www.google.com/)']) }}<br />
  {{ Form::textarea('content',Input::old('content'),['class' => 'form-control','placeholder' => 'Gönderi','data-uk-htmleditor' => '{markdown:true}']) }}<br />
  {{ Form::submit('Gönderi Oluştur',['class' => 'btn btn-lg btn-success'] )}}
{{ Form::close() }}
@stop
