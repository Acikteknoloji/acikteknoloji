<nav class="navbar navbar-default navbar-static-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      {{ HTML::linkRoute('home', 'Açık Teknoloji', [], ["class" => "navbar-brand"]) }}
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="{{ Request::root() }}">Anasayfa</a></li>
      </ul>
      <div class="navbar-form navbar-left" role="search">
        <div class="form-group">
          {{ Form::open(['route' => 'search','method' => 'get']) }}
          {{ Form::text('q',Request::input('q'),['class' => 'form-control','placeholder' => 'Ara'])}}
          {{ Form::hidden('where','posts') }}
        </div>
        <button type="submit" class="btn btn-default">Ara</button>
        {{ Form::close() }}
      </div>
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::check())
        <li>
          {{ HTML::linkRoute('subtitle.create', 'Yeni Alt Başlık', [], ['class' => 'btn btn-default btn-sm','style' => 'color:white']) }}
        </li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bildirimler <span class="badge" id="notifcount"></span> <span class="caret"></span></a>
          <ul class="dropdown-menu notifications" id="notifications">
            <li class="text-center"><h4>Gösterilecek başka bir bildirim yok</h4></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kullanıcı Paneli <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>{{ HTML::linkRoute('logout', 'Çıkış Yap', [], []) }}</li>
            @if(Auth::user()->hasRole('admin'))
            <li>{{ HTML::linkRoute('admin.home','Yönetici Paneli',[],[]) }}</li>
            @endif
          </ul>
        </li>
        @else
        <li>{{ HTML::linkRoute('login', 'Giriş', [], []) }}</li>
        <li>{{ HTML::linkRoute('register', 'Kaydol', [], []) }}</li>
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
@yield('extra.header')
