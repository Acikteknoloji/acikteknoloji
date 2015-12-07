<footer class="footer">
  <div class="container text-center">
    <p class="text-muted text-footer"><a href="https://github.com/Acikteknoloji/acikteknoloji">Açık Teknoloji <img src="{{ Request::root() }}/github.png" /> Açık Kaynak</a></p>
  </div>
</footer>
<script type="text/javascript">
var lastMessageID = 0;
checkMessages();
function checkMessages(){
  $.ajax('{{ Request::root() }}/notifs/' + lastMessageID,{

      data:{},
      success:function(data){
      // Count new messages
      if (Object.keys(data).length > 0){
          $.each(data,function(index, item){
            $(".notifications").scrollTop();
            var isread = (item.isRead == 1) ? "read" : "unread";
            var type = (item.type == 1) ? "gönderi" : "alt başlık";
            var button = (item.isRead == 0) ? "<button data-pid='" + item.id + "' id='markasread' class='btn btn-xs btn-default'>Okundu Olarak İşaretle</button>" : "<button data-pid='" + item.id + "' id='deletenotify' class='btn btn-xs btn-danger'>[X]</button>";
              $('#notifications').prepend("<li class='notification " + isread + "' id='n-"+ item.id +"'><span class='img-holder'><img src='http://www.lorempixel.com/60/60' class='img-responsive' /></span><span class='notification-holder'> <span class='title-holder'><strong>Yeni " + type + "</strong></span><br /> <span class='description-holder'><strong class='user-holder'>"+ item.actor_name +"</strong> adlı kullanıcı <strong>" + item.action_name  + "</strong> adında yeni bir "+ type +" oluşturdu. Yayınlanması için onayınız bekleniyor... </span><br /> <span class='date-holder'>"+ item.created_at +"<br /> "+ button +"</span><br /></span> </li>");
      });
      // We suggest that this is our last message
      lastMessageID = data[Object.keys(data).length-1].id;
      }
   }
  });

              $.ajax({
                type: 'GET',
                url: '{{ Request::root() }}/notifcount',
                data: {},
                dataType: 'json',
                success: function(data) {
                  $.each(data,function(index,element) {
                    $("#notifcount").text(element);
                  });
                }
              });
            }
            var intervalM = setInterval(function(){
     checkMessages();
},7000);
$(".notifications").on("click","button#markasread", function (){
  var nid = $(this).data('pid');
    $.ajax('{{ Request::root() }}/markasread/' + nid,{data:{},success:function(data){}});
    checkMessages();
    $("#n-" + nid).removeClass("unread");
    $("#n-" + nid).addClass("read");
    $("#notifcount").text($("#notifcount").text() - 1);
    $(this).attr("id","deletenotify");
    $(this).removeClass("btn-default");
    $(this).addClass("btn-danger");
    $(this).text("[X]");
});

$(".notifications").on("click","button#deletenotify", function (){
  var nid = $(this).data('pid');
    $.ajax('{{ Request::root() }}/deletenotify/' + nid,{data:{},success:function(data){}});
    checkMessages();
    $("#n-" + nid).remove();
});

$('.notifications').bind('click','button', function (e) { e.stopPropagation() });
</script>
