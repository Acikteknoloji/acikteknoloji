<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function posts()
	{
		return $this->hasMany('Post');
	}

	public function isAdminOn($id)
	{
		return DB::Table('user_subtitle')->where('isAdmin',1)->where('subtitle_id',$id)->where('user_id',Auth::user()->id)->exists();
	}

	public function subtitles()
	{
		return $this->hasMany('Subtitle','user_subtitle','user_id','subtitle_id');
	}

}
