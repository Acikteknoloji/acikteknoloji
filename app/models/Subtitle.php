<?php
class Subtitle extends Eloquent
{
  public $timestamps = false;
  protected $table = 'subtitles';

  public function posts()
  {
    return $this->hasMany('Post');
  }

  public function user()
  {
    return $this->belongsToMany('User','user_subtitle','user_id','subtitle_id');
  }
  
}
