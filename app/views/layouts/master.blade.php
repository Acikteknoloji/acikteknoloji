<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr">
  <head>
	<meta name="viewport" content="width=device-width,initial-scale=1">
    @include('partials.head')
  </head>
  <body>
    @include('partials.header')
    <div class="container wrapper-page">
      @yield('content')
    </div>
  </body>
  @include('partials.footer')
  @yield('extra.footer')
</html>
