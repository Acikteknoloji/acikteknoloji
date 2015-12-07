@extends('layouts.master')
@section('content')
<div class="row">
  @include('admin.partials.sidebar')
  <div class="col-lg-8">
    <div class="panel panel-default">
      <div class="panel-heading">Onaylanmamış Başlıklar</div>
      <div class="panel-body">
        <table class="table table-responsive table-hover">
          <thead>
            <th>Sayfa İsmi</th>
            <th>Sayfa Açıklaması</th>
            <th>Önizle</th>
            <th>Düzenle</th>
            <th>Yayın Durumu</th>
            <th>Sil</th>
          </thead>
          <tbody>
            @foreach($subtitles as $subtitle)
              <tr>
                <td>{{ $subtitle->name }}</td>
                <td>{{ $subtitle->description }}</td>
                <td>{{ HTML::linkRoute('subtitle','Önizle',[$subtitle->slug]) }}</td>
                <td>{{ HTML::linkRoute('admin.edit.subtitle','Düzenle',[$subtitle->slug]) }}</td>
                <td>{{ HTML::linkRoute('admin.activate.subtitle','Onayla',[$subtitle->slug]) }}</td>
                <td>{{ HTML::linkRoute('admin.delete.subtitle','Sil',[$subtitle->slug]) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{ $subtitles->links() }}
      </div>
    </div>
  </div>
</div>
@stop
