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
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::check())
        <li>
          {{ HTML::linkRoute('subtitle.create', 'Yeni Alt Başlık', [], ['class' => 'btn btn-default btn-sm','style' => 'color:white']) }}
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kullanıcı Paneli <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>{{ HTML::linkRoute('logout', 'Çıkış Yap', [], []) }}</li>
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
