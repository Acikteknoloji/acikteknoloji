<div class="col-lg-4">
  <div class="panel panel-default">
    <div class="panel-heading">Sayfalar</div>
    <div class="panel-body">
      <ul class="list-group">
        {{ HTML::linkRoute('moderation.home','Gönderiler',[$subtitle->slug],['class' => 'list-group-item']) }}
      </ul>
    </div>
  </div>
</div>
