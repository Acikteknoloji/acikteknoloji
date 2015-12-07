<?php
Event::listen('new_post',function($subtitle_id,$sender,$post_title){

  $noters = DB::Table('user_subtitle')->where('subtitle_id',$subtitle_id)->where('isAdmin','!=',0)->get();
  foreach($noters as $noter)
  {
    $noty = new Notification();
    $noty->action_name = $post_title;
    $noty->actor_name = $sender;
    $noty->user_id = $noter->user_id;
    $noty->type = 1;
    $noty->save();
  }
});

Event::listen('new_subtitle',function($sender,$subtitle){

  $noters = DB::Table('assigned_roles')->where('role_id',1)->get();
  foreach($noters as $noter)
  {
    $noty = new Notification();
    $noty->action_name = $subtitle;
    $noty->actor_name = $sender;
    $noty->user_id = $noter->user_id;
    $noty->type = 2;
    $noty->save();
  }
});
