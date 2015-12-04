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
      <a class="navbar-brand" href="{{ Request::root() }}">Açık Teknoloji</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="{{ Request::root() }}">Anasayfa</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::check())
        <li><a href="{{ Request::root() }}/subtitle/create" class="btn btn-default btn-sm" style="color:white;">Yeni Alt Başlık</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kullanıcı Paneli <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ Request::root() }}/logout">Çıkış Yap</a></li>
          </ul>
        </li>
        @else
        <li><a href="{{ Request::root() }}/login">Giriş</a></li>
        <li><a href="{{ Request::root() }}/register">Kaydol</a></li>
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
@yield('extra.header')
