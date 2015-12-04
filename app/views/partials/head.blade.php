<title>Açık Teknoloji</title>
{{ HTML::Style('css/bootstrap.min.css') }}
{{ HTML::Style('css/theme.min.css') }}
{{ HTML::Script('js/jquery.min.js') }}
{{ HTML::Script('js/bootstrap.min.js') }}
<style>
html {
position: relative;
min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 60px;
  background-color: #e4e4e4;
}
.wrapper-page{
  min-height: 100%;
  margin-bottom:60px;
}
.text-footer{
  margin:12px;
}
.text-footer a{
  text-decoration: none;
  color:#3c3c3c;
}
@yield('extra.style')
</style>
@yield('extra.head')
