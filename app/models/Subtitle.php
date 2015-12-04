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
    return $this->belongsTo('User');
  }
}
