@extends('layouts.master')
@section('content')
<div class="col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3 col-xs-9 col-xs-offset-2 vertical-center">
  <div class="panel panel-default">
    <div class="panel-heading">Kaydol</div>
    <div class="panel-body">
{{ Form::open() }}
  {{ Form::text('username',null,['class' => 'form-control','placeholder' => 'Kullanıcı adı']) }}<br />
  {{ Form::password('password',['class' => 'form-control','placeholder' => 'Şifre']) }}<br />
  {{ Form::text('email',null,['class' => 'form-control','placeholder' => 'E-Posta']) }}<br />
  {{ Form::submit('Kaydol',['class' => 'btn btn-sm btn-success'] )}}
{{ Form::close() }}
</div>
</div>
</div>
@stop
@section('extra.style')
.vertical-center {
  margin-top:14%;
}
@stop
