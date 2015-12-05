<div class="col-lg-4">
  <div class="panel panel-default">
    <div class="panel-heading">Sayfalar</div>
    <div class="panel-body">
      <ul class="list-group">
        {{ HTML::linkRoute('admin.home','Anasayfa',[],['class' => 'list-group-item']) }}
        {{ HTML::linkRoute('admin.subtitles','Başlıklar',[],['class' => 'list-group-item']) }}
        {{ HTML::linkRoute('admin.inactive.subtitles','Onaylanmamış Başlıklar',[],['class' => 'list-group-item']) }}
        {{ HTML::linkRoute('admin.users','Kullanıcılar',[],['class' => 'list-group-item'])}}
      </ul>
    </div>
  </div>
</div>
