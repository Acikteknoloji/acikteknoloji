<?php
class Notification extends Eloquent
{
  public $timestamps = true;
  protected $table = 'notifications';

  public function user()
  {
    return $this->belongsTo('User');
  }

  public function isRead()
  {
    return $this->created_at == $this->updated_at;
  }
}
