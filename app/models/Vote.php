<?php
class Vote extends Eloquent
{
  public $timestamps = false;
  protected $table = 'votes';

  public function post()
  {
    return $this->belongsTo('post');
  }

  public function user()
  {
    return $this->belongsTo('User');
  }
}
