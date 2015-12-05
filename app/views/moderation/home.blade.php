@extends('layouts.master')
@section('content')
<div class="row">
  @include('moderation.partials.sidebar')
  <div class="col-lg-8">
    <div class="panel panel-default">
      <div class="panel-heading">Gönderiler</div>
      <div class="panel-body">
        <table class="table table-responsive table-hover">
          <thead>
            <th>Başlık</th>
            <th>Yazar</th>
            <th>Yayın</th>
            <th>Düzenle</th>
            <th>Sil</th>
          </thead>
          <tbody>
            @foreach($posts as $post)
              <tr class="alert @if($post->publish == 1) alert-success @else alert-danger @endif">
                <td>{{ $post->title }}</td>
                <td>{{ $post->user->username }}</td>
                <td>@if($post->publish == 0) {{ HTML::linkRoute('moderation.publish','Yayınla',[$subtitle->slug,$post->id]) }} @else {{ HTML::linkRoute('moderation.draft','Taslağa Al',[$subtitle->slug,$post->id]) }} @endif </td>
                <td>{{ HTML::linkRoute('post.edit','Düzenle',[$post->id])}}</td>
                <td>{{ HTML::linkRoute('post.delete','Sil',[$post->id]) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@stop
