<?php
class Post extends Eloquent
{
  public $timestamps = true;
  protected $table = 'posts';

  public function subtitle()
  {
    return $this->belongsTo('Subtitle');
  }

  public function user()
  {
    return $this->belongsTo('User');
  }

  public function children()
  {
    return $this->where('isComment',$this->id);
  }

  public function positiveVotes()
  {
    return Vote::where('post_id',$this->id)->where('vote',1);
  }

  public function negativeVotes()
  {
    return Vote::where('post_id',$this->id)->where('vote',0);
  }

  public function votes()
  {
    return Vote::where('post_id',$this->id);
  }
}
