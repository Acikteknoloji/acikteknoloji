@extends('layouts.master')
@section('content')
<div class="row">
  @include('admin.partials.sidebar')
  <div class="col-lg-8">
    <div class="panel panel-default">
      <div class="panel-heading">Kullanıcılar</div>
      <div class="panel-body">
        <table class="table table-responsive table-hover">
          <thead>
            <th>ID</th>
            <th>Kullanıcı Adı</th>
            <th>E-Posta</th>
            <th>Rol</th>
            <th>Düzenle</th>
          </thead>
          <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>@foreach($user->roles()->get() as $role) {{ $role->name }} @endforeach</td>
            <td>{{ HTML::linkRoute('admin.user.edit','Düzenle',[$user->username]) }}</td>
          </tr>
        @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@stop
