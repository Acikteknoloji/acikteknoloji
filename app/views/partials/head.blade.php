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

.notifications{
  min-height:132px;
  max-height:264px;
  overflow-y:auto;
  overflow-x: hidden;
  width:346px;

}

.notification{
  width:328px;
  border-top:1px solid #d4d4d4;
  border-bottom:1px solid #d4d4d4;
  padding-bottom:8px;
  height:132px;
}
.read{
  background-color:#fff;
}
.unread{
  background-color:#eaeaea;
}
.notification .img-holder{
  width:70px;
  height:70px;
  float:left;
  display:block;
  padding:10px;
  margin-top:20px;
}
.notification .notification-holder{
  width:256px;
  height:auto;
  float:right;
  display:block;
  padding-top:6px;
}
.notification .btn-default{
  color:#fff;
  margin-bottom:10px;
}
@yield('extra.style')
</style>
@yield('extra.head')
