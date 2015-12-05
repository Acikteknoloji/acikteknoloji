@extends('layouts.master')
@section('content')
<div class="row">
  @include('admin.partials.sidebar')
  <div class="col-lg-8">
    <div class="panel panel-default">
      <div class="panel-heading">Kullanıcılar</div>
      <div class="panel-body">
        {{ Form::open() }}
          <div class="form-group">
            <label for="username">Kullanıcı Adı:</label>
            {{ $user->username }}
          </div>

          <div class="form-group">
            <label for="email">E-Posta:</label>
            {{ $user->email }}
          </div>

          <div class="form-group">
            <label for="role_ids[]">Kullanıcı Yetki Grupları:</label>
          {{ Form::select('role_ids[]',Role::lists('name','id'),$user->roles()->select('assigned_roles.role_id as id')->lists('id'),['class' => 'form-control','multiple' => 'multiple'])}}
          </div>
          {{ Form::submit('Kaydet',['class' => 'form-control btn btn-success btn-md'])}}
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
@stop
