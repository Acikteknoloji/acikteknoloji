@extends('layouts.master')
@section('content')
<div class="row">
  @include('subadmin.partials.sidebar')
  <div class="col-lg-8">
    <div class="panel panel-default">
      <div class="panel panel-heading">Kullanıcılar</div>
      <div class="panel-body">
        <table class="table table-responsive table-hover">
          <thead>
            <th>Kullanıcı Adı</th>
            <th>Moderatörlük</th>
            <th>İşlem</th>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td>{{ DB::Table('users')->where('id',$user->user_id)->first()->username }}</td>
                <td>@if($user->isAdmin == 1) Admin @elseif($user->isAdmin == 0) Kullanıcı @elseif($user->isAdmin == 2) Moderatör @endif
                <td>@if($user->isAdmin == 1) Admin @elseif($user->isAdmin == 0) {{ HTML::linkRoute('subadmin.makemod','Moderatör Yap',[$subtitle->slug,$user->user_id]) }} @elseif($user->isAdmin == 2) {{ HTML::linkRoute('subadmin.makeuser','Kullanıcı Yap',[$subtitle->slug,$user->user_id]) }} @endif</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@stop
