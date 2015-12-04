@extends('layouts.master')
@section('content')

@if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif
        {{ Form::open() }}
          {{ Form::text('name',null,['class' => 'form-control','placeholder' => 'Alt Başlık']) }}<br />
          {{ Form::text('slug',null,['class' => 'form-control','placeholder' => 'Kısa isim Örn: (alt-baslik)']) }}<br />
          {{ Form::textarea('description',null,['class' => 'form-control','placeholder' => 'Açıklama']) }}<br />
          {{ Form::textarea('css',null,['class' => 'form-control','placeholder' => 'Özel CSS']) }}<br />
          {{ Form::submit('Alt Başlık Oluştur',['class' => 'btn btn-lg btn-success'] )}}
        {{ Form::close() }}
@stop
